<?php

/** @var Binding $binding */
use Minute\Auth\CreateNewUser;
use Minute\Credit\CreditManager;
use Minute\Event\AdminEvent;
use Minute\Event\Binding;
use Minute\Event\UserAdminEvent;
use Minute\Event\UserCreditEvent;
use Minute\Event\UserProfileEvent;
use Minute\Event\UserSignupEvent;
use Minute\Menu\UserMenu;
use Minute\Panel\UserPanel;
use Minute\Profile\UserProfile;
use Minute\User\InitializeUser;
use Minute\User\UserActivityLogger;
use Minute\User\VerifyAccount;

$binding->addMultiple([
    //admin links
    ['event' => AdminEvent::IMPORT_ADMIN_MENU_LINKS, 'handler' => [UserMenu::class, 'adminLinks']],
    ['event' => AdminEvent::IMPORT_ADMIN_DASHBOARD_PANELS, 'handler' => [UserPanel::class, 'adminDashboardPanel']],
    //['event' => UserErrorEvent::USER_MAIL_BOUNCE, 'handler' => [SomeClass, 'sendMail']],

    //tabs
    ['event' => UserAdminEvent::IMPORT_MEMBERS_USER_TABS, 'handler' => [UserMenu::class, 'adminUserTabs']],

    //signup and verification
    ['event' => UserSignupEvent::USER_SIGNUP_BEGIN, 'handler' => [CreateNewUser::class, 'signup']],
    ['event' => UserSignupEvent::USER_SIGNUP_COMPLETE, 'handler' => [VerifyAccount::class, 'sendEmail']],
    ['event' => UserSignupEvent::USER_SIGNUP_COMPLETE, 'handler' => [InitializeUser::class, 'assignDefaultGroup'], 'priority' => -99],

    //for member's area
    ['event' => UserCreditEvent::USER_ADD_CREDITS, 'handler' => [CreditManager::class, 'addCredits']],
    ['event' => UserCreditEvent::USER_DEDUCT_CREDITS, 'handler' => [CreditManager::class, 'deductCredits']],

    //for member's area
    ['event' => UserProfileEvent::IMPORT_USER_GET_PROFILE_FIELDS, 'handler' => [UserProfile::class, 'getFields']],

    //activity logging
    ['event' => 'user.*', 'handler' => [UserActivityLogger::class, 'log'], 'priority' => -100],
]);