<?php

namespace App\Http\Middleware;

use App\Enums\Group\SectionEnum;
use App\Enums\Group\TypeEnum;
use App\Models\Location\City;
use App\Models\Unit;
use App\Objects\User\UserFilterObject;
use App\Repositories\UserRepository;
use App\Services\UserService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpFoundation\Response;

class SharedDataWithViews
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     * @throws \Exception
     */
    public function handle(Request $request, Closure $next): Response
    {
        $data = [
            'Units' => Unit::select('id', 'name', 'code', 'global_code')->get(),
            'Enums' => [
                "GroupSection" => array_map(function ($section) {
                    return [
                        'name' => $section->name,
                        'value' => $section->value,
                        'title' => SectionEnum::getLabel($section->value)
                    ];
                }, SectionEnum::cases()),
                "GroupType" => array_map(function ($type) {
                    $section = TypeEnum::getSection($type->value);
                    return [
                        'name' => $type->name,
                        'value' => $type->value,
                        'title' => TypeEnum::getLabel($type->value),
                        'parent' => [
                            'name' => $section->name,
                            'value' => $section->value,
                            'title' => SectionEnum::getLabel($section->value)
                        ]
                    ];
                }, TypeEnum::cases()),
                "CustomerType" => array_map(function ($type) {
                    return [
                        'name' => $type->name,
                        'value' => $type->value,
                        'title' => \App\Enums\Customer\TypeEnum::getLabel($type->value),
                        'badge' => \App\Enums\Customer\TypeEnum::getBadge($type->value),
                    ];
                }, \App\Enums\Customer\TypeEnum::cases()),
                "ProductType" => array_map(function ($type) {
                    return [
                        'name' => $type->name,
                        'value' => $type->value,
                        'title' => \App\Enums\Product\TypeEnum::getLabel($type->value),
                        'badge' => \App\Enums\Product\TypeEnum::getBadge($type->value),
                    ];
                }, \App\Enums\Product\TypeEnum::cases()),
                "TaskPriority" => array_map(function ($type) {
                    return [
                        'name' => $type->name,
                        'value' => $type->value,
                        'title' => \App\Enums\Task\PriorityEnum::getLabel($type->value),
                        'badge' => \App\Enums\Task\PriorityEnum::getBadge($type->value),
                    ];
                }, \App\Enums\Task\PriorityEnum::cases()),
                "TaskStatus" => array_map(function ($type) {
                    return [
                        'name' => $type->name,
                        'value' => $type->value,
                        'title' => \App\Enums\Task\StatusEnum::getLabel($type->value),
                        'badge' => \App\Enums\Task\StatusEnum::getBadge($type->value),
                    ];
                }, \App\Enums\Task\StatusEnum::cases()),
                "ServiceStatus" => array_map(function ($type) {
                    return [
                        'name' => $type->name,
                        'value' => $type->value,
                        'title' => \App\Enums\Service\StatusEnum::getLabel($type->value),
                        'badge' => \App\Enums\Service\StatusEnum::getBadge($type->value),
                    ];
                }, \App\Enums\Service\StatusEnum::cases()),
                "OfferStage" => array_map(function ($type) {
                    return [
                        'name' => $type->name,
                        'value' => $type->value,
                        'title' => \App\Enums\Offer\StageEnum::getLabel($type->value),
                        'badge' => \App\Enums\Offer\StageEnum::getBadge($type->value),
                    ];
                }, \App\Enums\Offer\StageEnum::cases()),
                "OfferStatus" => array_map(function ($type) {
                    return [
                        'name' => $type->name,
                        'value' => $type->value,
                        'title' => \App\Enums\Offer\StatusEnum::getLabel($type->value),
                        'badge' => \App\Enums\Offer\StatusEnum::getBadge($type->value),
                    ];
                }, \App\Enums\Offer\StatusEnum::cases()),

            ],
            'Location' => [
                'Cities' => City::get(),
            ],
            'Users' => (new UserService(new UserRepository()))->select(new UserFilterObject())->get(),
        ];
        $config = [
            'BaseUri' => getenv('APP_URL'),
            'Routes' => $this->getRoutes(),
        ];

        View::share('_config' , $config);
        View::share('_data' , $data);
        return $next($request);
    }


    private function getRoutes(): array
    {
        return array_map(function ($route) {
                            return [
                                'uri' => $route->uri(),
                                'name' => $route->getName(),
                                'methods' => $route->methods(),
                                'action' => $route->getActionName(),
                                'middleware' => $this->parseMiddleware($route->gatherMiddleware()),
                                'parameters' => $this->extractParameters($route->uri()),
                            ];
                        }, (Route::getRoutes())->getRoutes() ?? []);
    }

    private function parseMiddleware($middleware): \Illuminate\Support\Collection
    {
        return collect($middleware)->map(function ($mw) {
            if (str_contains($mw, ':')) {
                [$name, $params] = explode(':', $mw, 2);
                return [
                    'name' => $name,
                    'params' => explode(',', $params)
                ];
            }
            return ['name' => $mw, 'params' => []];
        });
    }

    private function extractParameters($uri): array
    {
        preg_match_all('/{(\w+)}/', $uri, $matches);
        return $matches[1];
    }
}
