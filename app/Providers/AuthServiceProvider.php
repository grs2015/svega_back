<?php

namespace App\Providers;

use App\Models\Tag;
use App\Models\Blog;
use App\Models\Main;
use App\Models\User;
use App\Models\Offer;
use App\Models\Benefit;
use App\Models\Section;
use App\Models\Activity;
use App\Models\Category;
use App\Models\Contact;
use App\Policies\TagPolicy;
use App\Policies\BlogPolicy;
use App\Policies\MainPolicy;
use App\Policies\OfferPolicy;
use App\Policies\BenefitPolicy;
use App\Policies\SectionPolicy;
use App\Policies\ActivityPolicy;
use App\Policies\CategoryPolicy;
use App\Policies\ContactPolicy;
use App\Policies\RegisteredUserPolicy;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Activity::class => ActivityPolicy::class,
        Blog::class => BlogPolicy::class,
        Category::class => CategoryPolicy::class,
        Contact::class => ContactPolicy::class,
        Tag::class => TagPolicy::class,
        Section::class => SectionPolicy::class,
        Offer::class => OfferPolicy::class,
        Benefit::class => BenefitPolicy::class,
        Main::class => MainPolicy::class,
        User::class => RegisteredUserPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        ResetPassword::createUrlUsing(function ($user, string $token) {
            return env('SPA_URL') . '/resetpassword?token=' . $token;
        });
    }
}
