<?php

/*
|--------------------------------------------------------------------------
| Anagami ERP – модул "Проекти": route дефиниции (СПРАВОЧЕН ФАЙЛ)
|--------------------------------------------------------------------------
|
| Този файл съдържа САМО извадените route дефиниции, свързани с проектите,
| от routes/web.php, routes/web-settings.php и routes/web-public.php.
| Не е предназначен да се зарежда директно – служи като референция какво
| трябва да присъства в routes/web.php на приемащото Laravel приложение.
|
| Оригиналният контекст на групите:
|   web.php          -> Route::group(['middleware' => ['auth', 'multi-company-select', 'email_verified'], 'prefix' => 'account'], ...)
|   web-settings.php -> Route::group(['middleware' => 'auth', 'prefix' => 'account/settings'], ...)
|   web-public.php   -> без middleware (публичен Gantt чрез hash)
|
*/

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ProjectLabelController;
use App\Http\Controllers\DiscussionController;
use App\Http\Controllers\ProjectFileController;
use App\Http\Controllers\ProjectNoteController;
use App\Http\Controllers\ProjectMemberController;
use App\Http\Controllers\ProjectRatingController;
use App\Http\Controllers\DiscussionFilesController;
use App\Http\Controllers\DiscussionReplyController;
use App\Http\Controllers\ProjectCalendarController;
use App\Http\Controllers\ProjectCategoryController;
use App\Http\Controllers\ProjectTemplateController;
use App\Http\Controllers\ProjectMilestoneController;
use App\Http\Controllers\DiscussionCategoryController;
use App\Http\Controllers\ProjectTemplateTaskController;
use App\Http\Controllers\ProjectTemplateMemberController;
use App\Http\Controllers\ProjectTemplateSubTaskController;
use App\Http\Controllers\GanttLinkController;
use App\Http\Controllers\ProjectSubCategoryController;
use App\Http\Controllers\ProjectTemplateMilestoneController;
use App\Http\Controllers\ProjectSettingController;
// Зависимости извън модула (Task, Client, Home):
use App\Http\Controllers\TaskLabelController;

/* ===================== routes/web.php (prefix: account) ===================== */

Route::group(['middleware' => ['auth', 'multi-company-select', 'email_verified'], 'prefix' => 'account'], function () {

    /* PROJECTS */
    Route::resource('projectCategory', ProjectCategoryController::class);
    Route::post('projects/change-status', [ProjectController::class, 'changeProjectStatus'])->name('projects.change_status');

    Route::resource('ProjectSubCategory', ProjectSubCategoryController::class);
    Route::get('get_project_sub_category/{id}', [ProjectSubCategoryController::class, 'getSubCategories'])->name('project.get_project_sub_category');


    Route::group(
        ['prefix' => 'projects'],
        function () {

            Route::get('import', [ProjectController::class, 'importProject'])->name('projects.import');
            Route::post('import', [ProjectController::class, 'importStore'])->name('projects.import.store');
            Route::post('import/process', [ProjectController::class, 'importProcess'])->name('projects.import.process');

            Route::post('assignProjectAdmin', [ProjectController::class, 'assignProjectAdmin'])->name('projects.assign_project_admin');
            Route::post('archive-restore/{id}', [ProjectController::class, 'archiveRestore'])->name('projects.archive_restore');
            Route::post('archive-delete/{id}', [ProjectController::class, 'archiveDestroy'])->name('projects.archive_delete');
            Route::get('archive', [ProjectController::class, 'archive'])->name('projects.archive');
            Route::post('apply-quick-action', [ProjectController::class, 'applyQuickAction'])->name('projects.apply_quick_action');
            Route::post('updateStatus/{id}', [ProjectController::class, 'updateStatus'])->name('projects.update_status');
            Route::post('store-pin', [ProjectController::class, 'storePin'])->name('projects.store_pin');
            Route::post('destroy-pin/{id}', [ProjectController::class, 'destroyPin'])->name('projects.destroy_pin');
            Route::post('gantt-data', [ProjectController::class, 'ganttData'])->name('projects.gantt_data');
            Route::post('invoiceList/{id}', [ProjectController::class, 'invoiceList'])->name('projects.invoice_list');
            Route::get('duplicate-project/{id}', [ProjectController::class, 'duplicateProject'])->name('projects.duplicate_project');

            Route::get('members/{id}', [ProjectController::class, 'members'])->name('projects.members');
            Route::get('pendingTasks/{id}', [ProjectController::class, 'pendingTasks'])->name('projects.pendingTasks');
            Route::get('labels/{id}', [TaskLabelController::class, 'labels'])->name('projects.labels');
            Route::resource('project-label', ProjectLabelController::class);

            Route::post('project-members/save-group', [ProjectMemberController::class, 'storeGroup'])->name('project-members.store_group');
            Route::resource('project-members', ProjectMemberController::class);

            Route::post('files/store-link', [ProjectFileController::class, 'storeLink'])->name('files.store_link');
            Route::get('files/download/{id}', [ProjectFileController::class, 'download'])->name('files.download');
            Route::get('files/thumbnail', [ProjectFileController::class, 'thumbnailShow'])->name('files.thumbnail');
            Route::post('files/multiple-upload', [ProjectFileController::class, 'storeMultiple'])->name('files.multiple_upload');
            Route::resource('files', ProjectFileController::class);

            Route::get('milestones/byProject/{id}', [ProjectMilestoneController::class, 'byProject'])->name('milestones.by_project');
            Route::post('/milestones/{id}/update-status', [ProjectMilestoneController::class, 'updateStatus'])->name('milestones.updateStatus');
            Route::resource('milestones', ProjectMilestoneController::class);


            // Discussion category routes
            Route::resource('discussion-category', DiscussionCategoryController::class);
            Route::post('discussion/setBestAnswer', [DiscussionController::class, 'setBestAnswer'])->name('discussion.set_best_answer');
            Route::resource('discussion', DiscussionController::class);
            Route::get('discussion-reply/get-replies/{id}', [DiscussionReplyController::class, 'getReplies'])->name('discussion-reply.get_replies');
            Route::resource('discussion-reply', DiscussionReplyController::class);

            // Discussion Files
            Route::get('discussion-files/download/{id}', [DiscussionFilesController::class, 'download'])->name('discussion_file.download');
            Route::resource('discussion-files', DiscussionFilesController::class);

            // Rating routes
            Route::resource('project-ratings', ProjectRatingController::class);

            Route::get('projects/burndown/{projectId?}', [ProjectController::class, 'burndown'])->name('projects.burndown');

            /* PROJECT TEMPLATE */
            Route::post('project-template/apply-quick-action', [ProjectTemplateController::class, 'applyQuickAction'])->name('project_template.apply_quick_action');
            Route::resource('project-template', ProjectTemplateController::class);
            Route::post('project-template-members/save-group', [ProjectTemplateMemberController::class, 'storeGroup'])->name('project_template_members.store_group');
            Route::resource('project-template-member', ProjectTemplateMemberController::class);
            Route::get('project-template-task/data/{templateId?}', [ProjectTemplateTaskController::class, 'data'])->name('project_template_task.data');
            Route::get('project-template-milestones/byProject/{id}', [ProjectTemplateMilestoneController::class, 'byProject'])->name('project-template-milestone.by_project');
            Route::post('/project-template-milestones/{id}/update-status', [ProjectTemplateMilestoneController::class, 'updateStatus'])->name('project-template-milestone.updateStatus');
            Route::resource('project-template-task', ProjectTemplateTaskController::class);
            Route::resource('project-template-milestone', ProjectTemplateMilestoneController::class);
            Route::resource('project-template-sub-task', ProjectTemplateSubTaskController::class);
            Route::resource('project-calendar', ProjectCalendarController::class);
        }
    );

    Route::get('project-notes/ask-for-password/{id}', [ProjectNoteController::class, 'askForPassword'])->name('project_notes.ask_for_password');
    Route::post('project-notes/check-password', [ProjectNoteController::class, 'checkPassword'])->name('project_notes.check_password');
    Route::post('project-notes/apply-quick-action', [ProjectNoteController::class, 'applyQuickAction'])->name('project_notes.apply_quick_action');
    Route::resource('project-notes', ProjectNoteController::class);
    Route::get('projects-ajax', [ProjectController::class, 'ajaxLoadProject'])->name('get.projects-ajax');
    Route::get('get-projects', [ProjectController::class, 'getProjects'])->name('get.projects');
    Route::resource('projects', ProjectController::class);

    Route::post('gantt_link.task_update', [GanttLinkController::class, 'taskUpdateController'])->name('gantt_link.task_update');
    Route::resource('gantt_link', GanttLinkController::class);
});

/* ============== routes/web-settings.php (prefix: account/settings) ============== */

Route::group(['middleware' => 'auth', 'prefix' => 'account/settings'], function () {
    Route::get('project-settings/create-category', [ProjectSettingController::class, 'createCategory'])->name('project-settings.createCategory');
    Route::post('project-settings/save-project-category', [ProjectSettingController::class, 'saveProjectCategory'])->name('project-settings.saveProjectCategory');
    Route::resource('project-settings', ProjectSettingController::class);
    Route::post('project-settings/{id?}', [ProjectSettingController::class, 'statusUpdate'])->name('project-settings.statusUpdate');
    Route::put('project-settings/change-status/{id?}', [ProjectSettingController::class, 'changeStatus'])->name('project-settings.changeStatus');
    Route::post('project-settings/set-default/{id?}', [ProjectSettingController::class, 'setDefault'])->name('project-settings.setDefault');
});

/* ===================== routes/web-public.php (публични) ===================== */
/* Забележка: HomeController не е част от модула – ganttData()/gantt() са в основното приложение. */

use App\Http\Controllers\HomeController;

Route::post('/gantt-chart-data/{id}', [HomeController::class, 'ganttData'])->name('front.gantt_data');
Route::get('/gantt-chart/{hash}', [HomeController::class, 'gantt'])->name('front.gantt');
