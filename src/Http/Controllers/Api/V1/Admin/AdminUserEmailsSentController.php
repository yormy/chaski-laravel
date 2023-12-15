<?php declare(strict_types=1);

namespace Yormy\ChaskiLaravel\Http\Controllers\Api\V1\Admin;

use Illuminate\Http\Request;
use Yormy\Apiresponse\Facades\ApiResponse;
use Yormy\ChaskiLaravel\Domain\Tracking\Repositories\EmailsSentRepository;
use Yormy\ChaskiLaravel\Domain\Tracking\Resources\EmailSentCollection;
use Yormy\ChaskiLaravel\Http\Controllers\Api\V1\BaseController;
use Yormy\ChaskiLaravel\Http\Requests\EmailShowUuidRequest;
use Yormy\ChaskiLaravel\Http\Requests\EmailShowXidRequest;
use Yormy\ChaskiLaravel\Services\Resolvers\UserResolver;

class AdminUserEmailsSentController extends BaseController
{
    private EmailsSentRepository $sentEmailRepository;

    public function __construct(Request $request)
    {
        parent::__construct($request);

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
        $email = $this->sentEmailRepository->getSentEmailForUserByUuid($this->user, $uuid);

        return $this->returnEmailContent($email);
    }

    public function getEmailContentsByXid(EmailShowXidRequest $request, string $xid)
    {
        $email = $this->sentEmailRepository->getSentEmailForUser($this->user, $xid);

        return $this->returnEmailContent($email);
    }

    private function returnEmailContent($email)
    {
        $this->sentEmailRepository->markOpenedForUser($this->user, $email->xid);

        return ApiResponse::withData(['html_content' => $email->content])
            ->successResponse();
    }

    private function decorateWithStatus($emails): array
    {
        foreach ($emails as $index => $data) {
            if (array_key_exists('opened_at',$data) && $data['opened_at']) {
                continue;
            }

            $status = [
                'key' => 'unread',
                'nature' => 'danger',
                'text' => __('bedrock-usersv2::status.new'),
            ];

            $emails[$index]['status'] = $status;
        }

        return $emails;
    }
}

