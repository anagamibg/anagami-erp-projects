# Anagami ERP – модул „Проекти“

Изнесен (екстрахиран) модул за управление на проекти от **Anagami ERP** – multi-tenant бизнес платформа на Laravel 10 (Blade, Bootstrap 4, jQuery, Yajra DataTables).

> **Частно / вътрешно ползване.** Репозиторията съдържа само кода, свързан с проектите, и **не е самостоятелно работещо приложение**. Модулът е предназначен да се копира върху основния Laravel проект на Anagami ERP (запазени са оригиналните относителни пътища). Не е лицензиран за публично разпространение.

---

## Съдържание

1. [Какво включва модулът](#какво-включва-модулът)
2. [Функционалности](#функционалности)
3. [Структура на папките](#структура-на-папките)
4. [Зависимости от останалата система](#зависимости-от-останалата-система)
5. [Изисквания](#изисквания)
6. [Интеграция](#интеграция)
7. [Бележки](#бележки)

---

## Какво включва модулът

Всичко, което е специфично за проектите в Anagami ERP:

- проекти, категории, подкатегории, статуси, етикети, отдели;
- членове на проект, файлове, бележки, рейтинг, активност;
- милестоуни и Gantt диаграма (вкл. връзки между задачи – `GanttLink`);
- шаблони на проекти (членове, милестоуни, задачи и подзадачи към шаблона);
- дискусии към проект (категории, отговори, файлове);
- настройки на проектите и известия (notifications) за проектни събития.

## Функционалности

Всичко по-долу е базирано на реалния код в репозиторията.

**Проекти (`ProjectController`)**
- Списък (Yajra DataTables), създаване, редакция, преглед, изтриване; групови действия (`applyQuickAction`: изтриване, архивиране, смяна на статус).
- Архив на проекти с възстановяване и окончателно изтриване (`ArchiveProjectsDataTable`).
- Смяна на статус, закачане (pin) / откачане на проект, назначаване на проектен администратор.
- Дублиране на проект (`duplicate-project`).
- Импорт на проекти от Excel (`ProjectImport`, `ImportProjectJob`).
- Календар на проектите (`ProjectCalendarController`).
- Публични настройки по проект: `public_taskboard`, `public_gantt_chart` (публична Gantt диаграма през hash – route в `web-public.php`).
- Проследяване на напредъка (`ProjectProgress` – по изпълнени задачи или по краен срок) и dashboard данни (`ProjectDashboard`).

**Табове в детайла на проект** (`projects/show` + `projects/ajax/*`): преглед, задачи, табло на задачите (taskboard), Gantt, членове, милестоуни, файлове, дискусии, бележки, рейтинг, активност, отработено време, разходи, фактури, оферти (estimates), плащания, поръчки, тикети, Miro board, burndown диаграма.

**Категории, подкатегории, статуси, етикети**
- `ProjectCategory`, `ProjectSubCategory`, `ProjectStatusSetting` (статуси с настройки), `ProjectLabel` / `ProjectLabelList`, `ProjectDepartment`.

**Членове** – добавяне на отделни членове и на групи (`ProjectMemberController::storeGroup`), `ProjectMember`.

**Файлове** – качване, множествено качване, добавяне на връзка, сваляне, миниатюри (`ProjectFileController`).

**Бележки** – проектни бележки, възможност за защита с парола (`ask-for-password` / `check-password`), споменавания (mention) и известия; лични бележки на потребител към проект (`ProjectUserNote`).

**Рейтинг** – оценка на проект (`ProjectRatingController`, `ProjectRating`).

**Милестоуни** – CRUD, филтър по проект, смяна на статус, флаг `add_to_budget` (`ProjectMilestoneController`).

**Gantt** – данни за диаграмата (`ganttData`), връзки между задачи (`GanttLinkController`, `GanttLink`), изгледи `gantt.blade.php` и `gantt_dhtml.blade.php`.

**Шаблони на проекти** (`ProjectTemplate*`) – шаблон с членове, милестоуни, задачи и подзадачи; контролери, DataTables и изгледи за управлението им.

**Дискусии** (`Discussion*`) – теми, категории, отговори, файлове, маркиране на „най-добър отговор“, споменавания и известия.

**Настройки** (`ProjectSettingController`) – статуси и категории на проекти, напомняне за срок на проект.

**Известия** – 12 Notification класа (нов проект, нов член, нова бележка, споменавания, смяна на статус, рейтинг, напомняне, нова дискусия / отговор и др.), 9 събития със слушатели, 14 observers.

**Конзолни команди**
- `send-project-reminder` – напомняне до администраторите преди крайния срок на проект;
- `projects-update-deadline-progress` – обновяване на напредъка на проекти, при които той се смята по краен срок.

## Структура на папките

Запазени са оригиналните относителни пътища спрямо корена на Laravel проекта.

| Категория | Път | Файлове |
|-----------|-----|--------:|
| Модели | `app/Models/` | 26 |
| Observers | `app/Observers/` | 14 |
| Events | `app/Events/` | 9 |
| Listeners | `app/Listeners/` | 9 |
| Notifications | `app/Notifications/` | 12 |
| DataTables | `app/DataTables/` | 6 |
| Контролери | `app/Http/Controllers/` | 21 |
| Form Requests | `app/Http/Requests/` | 17 |
| Импорт (Excel) и Job | `app/Imports/`, `app/Jobs/` | 2 |
| Конзолни команди | `app/Console/Commands/` | 2 |
| Traits | `app/Traits/` | 2 |
| Миграции (само проектно-специфичните) | `database/migrations/` | 23 |
| Seeders | `database/seeders/` | 3 |
| Factories | `database/factories/` | 1 |
| Изгледи – проекти | `resources/views/projects/` | 44 |
| Изгледи – шаблони на проекти | `resources/views/project-templates/` | 21 |
| Изгледи – настройки на проекти | `resources/views/project-settings/` | 8 |
| Изгледи – дискусии | `resources/views/discussions/` | 5 |
| Изгледи – Gantt (публични) | `resources/views/gantt*.blade.php` | 2 |
| Изгледи – известия | `resources/views/notifications/` | 11 |
| Изгледи – имейл | `resources/views/mail/project*/` | 2 |
| Изгледи – проектни джаджи в други страници (клиент, служител, dashboard) | `resources/views/{clients,employees,dashboard}/…/project*.blade.php` | 4 |
| Езикови фрагменти (EN) | `resources/lang/eng/_projects/` | 8 |
| Стилове (SCSS) | `resources/scss/project.scss`, `resources/sass/redesign/pages/_projects.scss` | 2 |
| Route референция | `routes/projects.routes.php` | 1 |
| Служебни | `.gitignore`, `README.md` | 2 |
| **Общо** | | **257** |

### Езикови фрагменти

Езиковите файлове на Anagami ERP (`app.php`, `messages.php`, `permissions.php`, `modules.php` …) са общи за цялата система и съдържат хиляди ключове, затова тук са включени **само ключовете, свързани с проекти и дискусии** – като отделни фрагменти в `resources/lang/eng/_projects/` (`app`, `messages`, `permissions`, `placeholders`, `email`, `clan`, `superadmin`, `modules`). Те се сливат (merge) с целевите файлове; подборът е по име на ключ, така че преди сливане е препоръчително бърз преглед. Българските преводи не са част от тази репозитория.

### Route референция

`routes/projects.routes.php` е **само справочен файл** – извадени са дефинициите за проекти от `routes/web.php`, `routes/web-settings.php` и `routes/web-public.php` (с оригиналните групи и middleware в коментар). Не се зарежда директно; съответните редове трябва да присъстват в route файловете на приемащото приложение.

## Зависимости от останалата система

Следното е **използвано от модула, но НЕ е включено** – трябва да съществува в приемащото приложение:

| Област | Какво | Къде се използва |
|--------|-------|------------------|
| Multi-tenancy | `App\Traits\HasCompany`, `App\Scopes\CompanyScope` / `ActiveScope`, `App\Models\Company`, `CompanyAddress` | моделите, DataTables, observers |
| Помощни функции | `app/Helper/start.php` (глобални функции като `user()`, `company()`, `global_setting()`, проверки на права `add_project_permission()` и др.), `App\Helper\Reply`, `Files`, `UserService`, `Common` | контролери, изгледи |
| Потребители и права | `User`, `EmployeeDetails`, `Role`, `Permission`, `PermissionRole`, `UserPermission`, `Module`, `Team` (отдели) | навсякъде |
| Задачи (отделен модул) | `Task`, `TaskUser`, `TaskboardColumn`, `TaskLabelList`, `TaskCategory`, `TaskSetting`, `SubTask`, `TaskLabelController`, `TaskController`, `TaskBoardController`, `TasksDataTable`; заявките `Requests/TemplateTasks/*` | табове „Задачи“, „Taskboard“, „Gantt“, шаблони на задачи, напредък на проект |
| Отработено време | `ProjectTimeLog`, `ProjectTimeLogBreak`, `TimelogController`, `TimeLogsDataTable`, съответните observers, notifications и отчети (`ProjectTimelog*`, `TimeLogProjectwiseReportDataTable`, `ProjectTimeLogsExport`, `ProjectwiseTimeLogExport`) | таб „Timelogs“, изчисления на напредък и бюджет |
| Клиенти | `Client*` (`ClientDetails`, `ClientCategory`, `ClientSubCategory`, `ClientContact`, `ClientController`) | проект ↔ клиент |
| Финанси | `Currency`, `Invoice`, `Estimate`, `Payment`, `Expense`, `Order`, `BankAccount`, `UnitType` и техните контролери/DataTables | табове „Фактури“, „Оферти“, „Плащания“, „Разходи“, „Поръчки“ |
| Тикети | `Ticket`, `TicketDataTable` | таб „Тикети“ |
| Договори | `ContractDiscussion*` (дискусии към договори) | не е включено – принадлежи към модул „Договори“ |
| Общи компоненти | `BaseModel`, `CoreRequest`, `CommonRequest`, `FileUploadObserver`, `UniversalSearch`, `MentionUser`, `Pinned`, `Notification`, `EmailNotificationSetting`, `SlackSetting`, `CustomField*` / `CustomFieldsTrait`, `IconTrait`, `ExcelImportable` / `ImportExcel`, `GlobalSetting`, `DashboardWidget` | модели, импорт, известия |
| Публична Gantt страница | `HomeController::gantt()` / `ganttData()` | route в `web-public.php` |
| Frontend ресурси | `public/` (JS/CSS библиотеки, DataTables, daterangepicker, Gantt библиотеки), `resources/views/layouts`, `components`, `sections` | всички изгледи |
| Базова схема на БД | Таблиците на проектите са създадени в монолитните миграции `2018_01_01_000000_create_worksuite_new_table.php`, `…_saas_upgrade_*` и `2022_08_12_000000_create_other_migration_till_date_table.php` на основния проект – те **не са включени**; тук са само допълващите проектно-специфични миграции | `database/migrations/` |
| Споделени миграции | `2023_04_18_124728_create_mention_users_table.php` (споменавания – смесена за задачи и проекти) и `2023_12_26_102738_add_project_column_in_orders_table.php` (колона `project_id` в поръчките) | принадлежат към други модули |

Основни таблици на модула: `projects`, `project_category`, `project_sub_categories`, `project_status_settings`, `project_labels`, `project_label_list`, `project_departments`, `project_members`, `project_files`, `project_notes`, `project_user_notes`, `project_ratings`, `project_activity`, `project_milestones`, `project_settings`, `gantt_links`, `project_templates`, `project_template_members`, `project_template_milestone`, `project_template_tasks`, `project_template_sub_tasks`, `project_template_task_users`, `discussions`, `discussion_categories`, `discussion_replies`, `discussion_files`.

## Изисквания

- **PHP** ≥ 8.2 (в продукция се ползва 8.3)
- **Laravel** 10
- **MariaDB** 11.x или **MySQL** 8
- Пакети в основния проект: `yajra/laravel-datatables-oracle`, `maatwebsite/excel` (импорт), Bootstrap 4 / jQuery фронтенд (без SPA фреймуърк)

## Интеграция

1. **Копиране на файловете** върху Laravel проекта (запазва се структурата на папките):

   ```bash
   rsync -av --exclude='.git' --exclude='README.md' --exclude='.gitignore' \
         --exclude='routes/' --exclude='resources/lang/' \
         ./ /път/до/anagami-erp/
   ```

2. **Езикови фрагменти** – слейте съдържанието на `resources/lang/eng/_projects/*.php` в съответните `resources/lang/eng/*.php` (и в използваните други езици).

3. **Миграции** – базовата схема трябва вече да е налична; след това:

   ```bash
   php artisan migrate
   ```

   Част от миграциите (`*_add_view_project_*_permission*`, `*_add_project_label_permission_table`) добавят права към модулите на системата и изискват наличието на `Module`, `Permission`, `Role`, `Company`.

4. **Observers и събития** – регистрирайте в `app/Providers/EventServiceProvider.php`:

   ```php
   // $listen
   NewProjectEvent::class        => [NewProjectListener::class],
   NewProjectMemberEvent::class  => [NewProjectMemberListener::class],
   ProjectNoteEvent::class       => [ProjectNoteListener::class],
   ProjectNoteMentionEvent::class=> [ProjectNoteMentionListener::class],
   ProjectNoteUpdateEvent::class => [ProjectNoteUpdateListener::class],
   ProjectReminderEvent::class   => [ProjectReminderListener::class],
   DiscussionEvent::class        => [DiscussionListener::class],
   DiscussionMentionEvent::class => [DiscussionMentionListener::class],
   DiscussionReplyEvent::class   => [DiscussionReplyListener::class],

   // $observers
   Project::class                   => [ProjectObserver::class],
   ProjectCategory::class           => [ProjectCategoryObserver::class],
   ProjectFile::class               => [FileUploadObserver::class],
   ProjectMember::class             => [ProjectMemberObserver::class],
   ProjectMilestone::class          => [ProjectMilestoneObserver::class],
   ProjectNote::class               => [ProjectNoteObserver::class],
   ProjectRating::class             => [ProjectRatingObserver::class],
   ProjectSetting::class            => [ProjectSettingObserver::class],
   ProjectStatusSetting::class      => [ProjectStatusSettingObserver::class],
   ProjectTemplate::class           => [ProjectTemplateObserver::class],
   ProjectTemplateMilestone::class  => [ProjectTemplateMilestoneObserver::class],
   Discussion::class                => [DiscussionObserver::class],
   DiscussionCategory::class        => [DiscussionCategoryObserver::class],
   DiscussionReply::class           => [DiscussionReplyObserver::class],
   DiscussionFile::class            => [DiscussionFileObserver::class],
   ```

5. **Route-ове** – прегледайте `routes/projects.routes.php` и добавете липсващите дефиниции в `routes/web.php`, `routes/web-settings.php` и `routes/web-public.php` (в съответните групи с middleware `auth`, `multi-company-select`, `email_verified`).

6. **Планирани команди** – в `app/Console/Kernel.php` регистрирайте командите и графика:

   ```php
   $schedule->command('projects-update-deadline-progress')->dailyAt('01:00');
   $schedule->command('send-project-reminder')->dailyAt('01:10');
   ```

7. **Стилове** – SCSS файловете (`resources/scss/project.scss`, `resources/sass/redesign/pages/_projects.scss`) се импортират в основния build (Laravel Mix), след което `npm run dev` / `npm run prod`.

8. **Кешове** – `php artisan view:clear && php artisan route:cache && php artisan config:cache`.

## Бележки

- Репозиторията е **частна** и е предназначена за вътрешно ползване от екипа на Anagami.
- Изключени са умишлено: `vendor/`, `node_modules/`, `public/` ресурси, `.env`, документация на сървъра и всичко с пароли, ключове или адреси на сървъри.
- Задачите (Task\*), отработеното време, тикетите, договорите (вкл. `ContractDiscussion*`) и останалите споделени компоненти принадлежат на други модули – вж. таблицата със зависимости.
- Файлът `resources/views/gantt_dhtml.blade.php` е копиран без промяна и съдържа остатъчна препратка към тестов хост на оригиналния фреймуърк; при интеграция заменете я с локалния път до `daterangepicker.css`.
