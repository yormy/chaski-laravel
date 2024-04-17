<?php

declare(strict_types=1);

namespace Yormy\ChaskiLaravel\Http\Controllers\Api\V1\User;

use Illuminate\Http\Request;
use Yormy\Apiresponse\Facades\ApiResponse;
use Yormy\ChaskiLaravel\Domain\Shared\DataObjects\SentEmailResponseData;
use Yormy\ChaskiLaravel\Domain\Shared\DataObjects\SentNotificationResponseData;
use Yormy\ChaskiLaravel\Domain\Tracking\Repositories\EmailsSentRepository;
use Yormy\ChaskiLaravel\Domain\Tracking\Repositories\NotificationsSentRepository;
use Yormy\ChaskiLaravel\Http\Controllers\Api\V1\BaseController;
use Yormy\ChaskiLaravel\Http\Controllers\Api\V1\Traits\EmailsSentDecoratorTrait;

class UserNewMessagesController extends BaseController
{
    use EmailsSentDecoratorTrait;

    private EmailsSentRepository $sentEmailRepository;

    private NotificationsSentRepository $notificationsSentRepository;

    public function __construct(Request $request)
    {
        parent::__construct($request);

        $this->sentEmailRepository = new EmailsSentRepository();
        $this->notificationsSentRepository = new NotificationsSentRepository();
    }

    public function index(Request $request)
    {
        $emails = $this->sentEmailRepository->getAllNewForUser($this->user); // this is not new !
        $sentEmails = collect(SentEmailResponseData::collect($emails)->toArray());

        $notifications = $this->notificationsSentRepository->getAllNewForUser($this->user);
        $sentNotification = collect(SentNotificationResponseData::collect($notifications)->toArray());

        $all = $sentEmails->merge($sentNotification);
        $sorted = $all->sortByDesc(['created_at']);

        // decorate ?
        dd($all);

        return ApiResponse::withData($sorted)->successResponse();

    }
}
