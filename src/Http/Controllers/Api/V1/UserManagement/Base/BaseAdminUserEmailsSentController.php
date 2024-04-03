<?php

declare(strict_types=1);

namespace Yormy\ChaskiLaravel\Http\Controllers\Api\V1\UserManagement\Base;

use Illuminate\Http\Request;
use Yormy\Apiresponse\Facades\ApiResponse;
use Yormy\ChaskiLaravel\Domain\Tracking\Repositories\EmailsSentRepository;
use Yormy\ChaskiLaravel\Domain\Tracking\Resources\EmailSentCollection;
use Yormy\ChaskiLaravel\Domain\Tracking\Resources\EmailSentLogCollection;
use Yormy\ChaskiLaravel\Domain\Tracking\Resources\EmailSentUrlClickCollection;
use Yormy\ChaskiLaravel\Http\Controllers\Api\V1\Traits\EmailsSentDecoratorTrait;
use Yormy\ChaskiLaravel\Http\Requests\EmailShowUuidRequest;
use Yormy\ChaskiLaravel\Http\Requests\EmailShowXidRequest;

class BaseAdminUserEmailsSentController
{
    use EmailsSentDecoratorTrait;

    private EmailsSentRepository $sentEmailRepository;

    public function __construct(Request $request)
    {
        $this->sentEmailRepository = new EmailsSentRepository();
    }

    public function index(Request $request, $member_xid)
    {
        $user = $this->getUser($member_xid);
        $emails = $this->sentEmailRepository->getAllForUser($user);

        $emails = (new EmailSentCollection($emails))->toArray($request);
        $emails = $this->addRelations($request, $emails);

        return ApiResponse::withData($emails)
            ->successResponse();
    }

    public function getEmailContentsByUuid(EmailShowUuidRequest $request, string $uuid)
    {
        $email = $this->sentEmailRepository->getSentEmailByUuid($uuid);

        return ApiResponse::withData(['html_content' => $email->content])
            ->successResponse();
    }

    public function getEmailContentsByXid(EmailShowXidRequest $request, string $xid)
    {
        $email = $this->sentEmailRepository->getSentEmailByXid($xid);

        return ApiResponse::withData(['html_content' => $email->content])
            ->successResponse();
    }

    private function addRelations(Request $request, array $emails): array
    {
        foreach ($emails as $index => $email) {
            $sentEmailId = $email['id'];
            $sentEmail = $this->sentEmailRepository->findSentEmailByIdOrFail($sentEmailId);
            $sentEmail->load(['logs', 'urlClicks']);

            $logs = (new EmailSentLogCollection($sentEmail->logs))->toArray($request);
            if ($logs) {
                $emails[$index]['logs'] = $logs;
            }

            $clicks = (new EmailSentUrlClickCollection($sentEmail->urlClicks))->toArray($request);
            if ($clicks) {
                $emails[$index]['clicks'] = $clicks;
            }
        }

        return $emails;
    }
}
