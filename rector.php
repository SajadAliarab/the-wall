<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\Set\ValueObject\SetList;
use RectorLaravel\Set\LaravelSetList;

return RectorConfig::configure()
    ->withPaths([
        __DIR__ . '/app',
        __DIR__ . '/config',
        __DIR__ . '/database',
        __DIR__ . '/routes',
        __DIR__ . '/tests',
    ])
    ->withRules([
        RectorLaravel\Rector\Class_\AnonymousMigrationsRector::class,
        RectorLaravel\Rector\Expr\AppEnvironmentComparisonToParameterRector::class,
        RectorLaravel\Rector\Coalesce\ApplyDefaultInsteadOfNullCoalesceRector::class,
        RectorLaravel\Rector\MethodCall\AssertSeeToAssertSeeHtmlRector::class,
        RectorLaravel\Rector\MethodCall\AssertStatusToAssertMethodRector::class,
        RectorLaravel\Rector\StaticCall\AssertWithClassStringToTypeHintedClosureRector::class,
        RectorLaravel\Rector\StaticCall\CarbonSetTestNowToTravelToRector::class,
        RectorLaravel\Rector\StaticCall\DispatchToHelperFunctionsRector::class,
        RectorLaravel\Rector\MethodCall\EloquentOrderByToLatestOrOldestRector::class,
        RectorLaravel\Rector\MethodCall\EloquentWhereRelationTypeHintingParameterRector::class,
        RectorLaravel\Rector\MethodCall\EloquentWhereTypeHintClosureParameterRector::class,
        RectorLaravel\Rector\Empty_\EmptyToBlankAndFilledFuncRector::class,
        RectorLaravel\Rector\ArrayDimFetch\EnvVariableToEnvHelperRector::class,
        RectorLaravel\Rector\MethodCall\JsonCallToExplicitJsonCallRector::class,
        RectorLaravel\Rector\ClassMethod\MigrateToSimplifiedAttributeRector::class,
        RectorLaravel\Rector\Class_\ModelCastsPropertyToCastsMethodRector::class,
        RectorLaravel\Rector\FuncCall\NotFilledBlankFuncCallToBlankFilledFuncCallRector::class,
        RectorLaravel\Rector\FuncCall\NowFuncWithStartOfDayMethodCallToTodayFuncRector::class,
        RectorLaravel\Rector\PropertyFetch\OptionalToNullsafeOperatorRector::class,
        RectorLaravel\Rector\Class_\PropertyDeferToDeferrableProviderToRector::class,
        RectorLaravel\Rector\StaticCall\Redirect301ToPermanentRedirectRector::class,
        RectorLaravel\Rector\MethodCall\RedirectBackToBackHelperRector::class,
        RectorLaravel\Rector\MethodCall\RedirectRouteToToRouteHelperRector::class,
        RectorLaravel\Rector\MethodCall\RefactorBlueprintGeometryColumnsRector::class,
        RectorLaravel\Rector\FuncCall\RemoveDumpDataDeadCodeRector::class,
        RectorLaravel\Rector\Class_\RemoveModelPropertyFromFactoriesRector::class,
        RectorLaravel\Rector\FuncCall\RemoveRedundantValueCallsRector::class,
        RectorLaravel\Rector\FuncCall\RemoveRedundantWithCallsRector::class,
        RectorLaravel\Rector\StaticCall\ReplaceAssertTimesSendWithAssertSentTimesRector::class,
        RectorLaravel\Rector\Class_\ReplaceExpectsMethodsInTestsRector::class,
        RectorLaravel\Rector\PropertyFetch\ReplaceFakerInstanceWithHelperRector::class,
        RectorLaravel\Rector\MethodCall\ReplaceServiceContainerCallArgRector::class,
        RectorLaravel\Rector\MethodCall\ReplaceWithoutJobsEventsAndNotificationsWithFacadeFakeRector::class,
        RectorLaravel\Rector\StaticCall\RequestStaticValidateToInjectRector::class,
        RectorLaravel\Rector\ArrayDimFetch\RequestVariablesToRequestFacadeRector::class,
        RectorLaravel\Rector\MethodCall\ResponseHelperCallToJsonResponseRector::class,
        RectorLaravel\Rector\ArrayDimFetch\ServerVariableToRequestFacadeRector::class,
        RectorLaravel\Rector\ArrayDimFetch\SessionVariableToSessionFacadeRector::class,
        RectorLaravel\Rector\FuncCall\SleepFuncToSleepStaticCallRector::class,
        RectorLaravel\Rector\Expr\SubStrToStartsWithOrEndsWithStaticMethodCallRector\SubStrToStartsWithOrEndsWithStaticMethodCallRector::class,
        RectorLaravel\Rector\Class_\UnifyModelDatesWithCastsRector::class,
        RectorLaravel\Rector\MethodCall\UseComponentPropertyWithinCommandsRector::class,
        RectorLaravel\Rector\MethodCall\ValidationRuleArrayStringValueToArrayRector::class,
        RectorLaravel\Rector\MethodCall\WhereToWhereLikeRector::class,
    ])
    ->withSets([
        SetList::DEAD_CODE,
        LaravelSetList::LARAVEL_120,
        LaravelSetList::LARAVEL_ELOQUENT_MAGIC_METHOD_TO_QUERY_BUILDER,
        LaravelSetList::LARAVEL_CODE_QUALITY,
        LaravelSetList::LARAVEL_COLLECTION,
        LaravelSetList::LARAVEL_IF_HELPERS,
        LaravelSetList::LARAVEL_LEGACY_FACTORIES_TO_CLASSES,
        LaravelSetList::ARRAY_STR_FUNCTIONS_TO_STATIC_CALL,
    ]);
