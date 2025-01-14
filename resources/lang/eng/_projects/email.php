<?php

// Fragment: only the keys used by the Projects module (extracted from resources/lang/eng/email.php).
// Merge into the application's file, e.g. array_merge(require 'app.php', require '_projects/app.php').

return [
    'newProjectMember' => [
        'subject' => 'Project Update: You have been assigned a new project',
        'text' => 'Exciting news! You\'ve been assigned a new project.',
        'text2' => 'To get started, log in to your account and check out the project details.',
        'action' => 'View Project',
        'mentionProject' => 'You Have Been Mention On New Project',
        'mentionText' => 'You have been mentioned on project',
        'mentionProjectNote' => 'Project Update: You Have Been Mention On New Project Note',
        'mentionNoteText' => 'You have been mentioned on project Note',
    ],
    'projectNote' => [
        'mentionSubject' => 'You have Been Mention On New Project Note',
        'mentionText' => 'You have been mentioned on New Project Note',
        'text' => 'New note added for',
        'action' => 'View Note',
        'subject' => 'New note added for Project',
        'updateSubject' => 'Project Note Updated',
        'updateContent' => 'A note in your project has been updated. Please take a moment to review the changes.',
    ],
    'newProject' => [
        'subject' => 'New Project Added',
        'text' => 'A new project added with the name',
        'withName' => 'with name.',
        'loginNow' => ' Login now to view the project.',
    ],
    'newProjectStatus' => [
        'subject' => 'Project Status Updated',
        'text' => 'Project Status has been changed',
        'withName' => 'with name.',
        'loginNow' => ' Login now to view the project.',
    ],
    'projectReminder' => [
        'text' => 'This is to remind you about the due date of the following projects which is',
        'subject' => 'Project Reminder',
        'action' => 'View Projects',
    ],
    'discussionReply' => [
        'subject' => ' replied to ',
        'text' => 'You have received a reply on ',
        'action' => 'View Discussion',
    ],
    'discussion' => [
        'subject' => 'New discussion started ',
        'action' => 'View Discussion',
        'mentionSubject' => 'Mentioned On Discussion',
        'mentionContent' => 'You have been mentioned on new Project Discussion',
    ],
    'rating' => [
        'subject' => 'Rating added on project',
        'text' => 'Rating added on project-.',
    ],
    'projectRating' => [
        'subject' => 'New project rating',
        'action' => 'Show Rating',
        'text' => 'New project rating received for the project ',
    ],
];
