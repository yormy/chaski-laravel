<?php declare(strict_types=1);

namespace Yormy\ChaskiLaravel\Http\Controllers\Api\V1\UserManagement;

use Illuminate\Http\Request;
use Yormy\Apiresponse\Facades\ApiResponse;
use Yormy\ChaskiLaravel\Domain\Tracking\Repositories\EmailsSentRepository;
use Yormy\ChaskiLaravel\Domain\Tracking\Resources\EmailSentCollection;
use Yormy\ChaskiLaravel\Http\Controllers\Api\V1\Traits\EmailsSentDecoratorTrait;
use Yormy\ChaskiLaravel\Http\Requests\EmailShowUuidRequest;
use Yormy\ChaskiLaravel\Http\Requests\EmailShowXidRequest;
use Yormy\ChaskiLaravel\Services\Resolvers\UserResolver;

class AdminUserEmailsSentController
{
    use EmailsSentDecoratorTrait;
    private EmailsSentRepository $sentEmailRepository;

    public function __construct(Request $request)
    {
        $this->sentEmailRepository = new EmailsSentRepository();
    }

    public function index(Request $request, $member_xid)
    {
        $member = UserResolver::getMemberOnXId($member_xid);
        $emails = $this->sentEmailRepository->getAllForUser($member);

        $emails = (new EmailSentCollection($emails))->toArray($request);
        $emails = $this->decorateWithStatus($emails);

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
}

