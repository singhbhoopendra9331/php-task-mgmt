<?php

namespace App\Controllers;

use App\Models\Task;
use App\Core\Response;
use App\Core\BaseController;
use App\Services\AuthService;

class HomeController extends BaseController
{
    public function index()
    {
        $this->redirect('/dashboard');
    }

    public function dashboard()
    {
        if (!(new AuthService())->check()) {
            $this->redirect('/login');
        }

        Response::view('dashboard/index', [
            'title' => 'Project Timeline',
            'subtitle' => 'Track progress across tasks and team.',
            'tasks' => (new Task())->all(),
            'weeks' => [
                'May 5 – May 11',
                'May 12 – May 18',
                'May 19 – May 25',
                'May 26 – Jun 1',
                'Jun 2 – Jun 8',
                'Jun 9 – Jun 15',
            ],
            'todayPercent' => 42,
            'timeline' => $this->timelineData(),
        ], 'dashboard');
    }

    private function timelineData(): array
    {
        return [
            [
                'name' => 'Project Planning',
                'tasks' => [
                    ['title' => 'Project Kickoff', 'assignee' => 'Heera Singh', 'initials' => 'HS', 'done' => true, 'color' => 'emerald', 'start' => 2, 'width' => 14],
                    ['title' => 'Define Objectives', 'assignee' => 'Priya Sharma', 'initials' => 'PS', 'done' => true, 'color' => 'emerald', 'start' => 8, 'width' => 16],
                    ['title' => 'Requirements Gathering', 'assignee' => 'Rahul Verma', 'initials' => 'RV', 'done' => true, 'color' => 'blue', 'start' => 16, 'width' => 18],
                    ['title' => 'Project Plan & Timeline', 'assignee' => 'Heera Singh', 'initials' => 'HS', 'done' => false, 'color' => 'violet', 'start' => 24, 'width' => 16],
                ],
            ],
            [
                'name' => 'Design',
                'tasks' => [
                    ['title' => 'Wireframes', 'assignee' => 'Priya Sharma', 'initials' => 'PS', 'done' => true, 'color' => 'blue', 'start' => 22, 'width' => 14],
                    ['title' => 'UI/UX Design', 'assignee' => 'Ananya Rao', 'initials' => 'AR', 'done' => false, 'color' => 'violet', 'start' => 30, 'width' => 20],
                    ['title' => 'Design Review', 'assignee' => 'Heera Singh', 'initials' => 'HS', 'done' => false, 'color' => 'amber', 'start' => 42, 'width' => 10],
                ],
            ],
            [
                'name' => 'Development',
                'tasks' => [
                    ['title' => 'Frontend Development', 'assignee' => 'Rahul Verma', 'initials' => 'RV', 'done' => false, 'color' => 'orange', 'start' => 36, 'width' => 28],
                    ['title' => 'Backend Development', 'assignee' => 'Vikram Patel', 'initials' => 'VP', 'done' => false, 'color' => 'rose', 'start' => 40, 'width' => 30],
                    ['title' => 'API Integration', 'assignee' => 'Rahul Verma', 'initials' => 'RV', 'done' => false, 'color' => 'amber', 'start' => 52, 'width' => 18],
                    ['title' => 'Testing', 'assignee' => 'Priya Sharma', 'initials' => 'PS', 'done' => false, 'color' => 'teal', 'start' => 62, 'width' => 16],
                ],
            ],
            [
                'name' => 'Launch',
                'tasks' => [
                    ['title' => 'UAT', 'assignee' => 'Heera Singh', 'initials' => 'HS', 'done' => false, 'color' => 'indigo', 'start' => 72, 'width' => 12],
                    ['title' => 'Bug Fixing', 'assignee' => 'Vikram Patel', 'initials' => 'VP', 'done' => false, 'color' => 'orange', 'start' => 78, 'width' => 12],
                    ['title' => 'Go Live', 'assignee' => 'Heera Singh', 'initials' => 'HS', 'done' => false, 'color' => 'emerald', 'start' => 88, 'width' => 8, 'milestone' => true],
                ],
            ],
        ];
    }
}
