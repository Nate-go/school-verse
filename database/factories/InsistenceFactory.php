<?php

namespace Database\Factories;

use App\Constant\Insistence;
use App\Constant\InsistenceTypes;
use App\Constant\UserRole;
use App\Models\User;
use App\Services\FactoryService;
use App\Services\UtilService;
use App\Traits\ServiceInjection\InjectionService;
use DB;
use Illuminate\Database\Eloquent\Factories\Factory;
use Str;

class InsistenceFactory extends Factory
{
    use InjectionService;

    public $statuses = [];

    public $statusRanges = [[30, 35], [20, 25], [45, 50]];

    protected $factoryService;

    public $insistencesContent = [
        UserRole::TEACHER => [
            [
                [
                    'type' => 'Computer Usage Request',
                    'content' => "Dear Admin,\n\nI am writing to request permission to use the computer lab for a programming project on October 10th, from 2:00 PM to 4:00 PM. I assure you that I will adhere to all rules and regulations regarding computer usage. Your approval for this request would be greatly appreciated.\n\nThank you, Michael Brown"
                ],
                [
                    'type' => 'Computer Usage Request',
                    'content' => "Dear Admin,\n\nI am seeking permission to use the computer lab for a coding project on November 12th, from 10:00 AM to 12:00 PM. I assure you that I will strictly adhere to all lab rules. Your approval for this request would be highly appreciated.\n\nThank you, William Taylor"
                ],
            ],
            [
                [
                    'type' => 'Service Usage Request',
                    'content' => "Dear Admin,\n\nI would like to request the use of the audiovisual equipment for a presentation on November 5th, from 3:00 PM to 5:00 PM. Please let me know if this request can be accommodated. I understand and agree to comply with any associated guidelines.\n\nThank you for your consideration.\n\nSincerely, Sarah Davis"
                ],
                [
                    'type' => 'Service Usage Request',
                    'content' => "Dear Admin,\n\nI would like to request the use of the photography equipment for a school project on December 8th, from 9:00 AM to 11:00 AM. Please let me know if this request can be accommodated. I am committed to following all guidelines and ensuring proper care of the equipment.\n\nThank you for your consideration.\n\nSincerely, Mia Evans"
                ],
                [
                    'type' => 'Service Usage Request',
                    'content' => "Dear Admin,\n\nI would like to request the use of the sound equipment for a music performance on December 20th, from 5:00 PM to 7:00 PM. Please let me know if this request can be accommodated. I am committed to following all guidelines for equipment usage.\n\nThank you for your consideration.\n\nSincerely, Harper Wilson"
                ],
            ],

            [
                [
                    'type' => 'Place Usage Request',
                    'content' => "Dear Admin,\n\nI am seeking permission to use the school gymnasium for a basketball tournament on December 15th, from 9:00 AM to 12:00 PM. I assure you that all necessary precautions will be taken to ensure the area is left in good condition. Your approval for this request would be highly valued.\n\nBest regards, Kevin Green"
                ],
                [
                    'type' => 'Place Usage Request',
                    'content' => "Dear Admin,\n\nI am writing to request permission to use the school auditorium for a drama rehearsal on October 28th, from 4:00 PM to 7:00 PM. I assure you that we will take every precaution to leave the area in good condition. Your approval for this request would be highly valued.\n\nBest regards, Liam Martinez"
                ],
                [
                    'type' => 'Place Usage Request',
                    'content' => "Dear Admin,\n\nI am writing to request permission to use the outdoor basketball court for a friendly match on October 5th, from 3:00 PM to 5:00 PM. I assure you that we will leave the area in good condition. Your approval for this request would be highly valued.\n\nBest regards, Oliver Young"
                ],
            ],
        ],
        UserRole::STUDENT => [
            [
                [
                    'type' => 'Exam Review Request',
                    'content' => "Dear Admin,\n\nI would like to request a review of my recent exam for the Mathematics course. I have some concerns regarding specific questions. Could you please arrange for a review session with the respective teacher at your earliest convenience? Thank you for your assistance.\n\nBest regards, Jane Smith"
                ],
                [
                    'type' => 'Exam Review Request',
                    'content' => "Dear Admin,\n\nI hope this message finds you in good health. I am requesting a review of my recent Biology exam. There are specific questions I would like to discuss for better understanding. Could you kindly arrange a review session with the Biology teacher? I am available on weekdays after 3:00 PM.\n\nThank you for your assistance.\n\nSincerely, Olivia Clark"
                ],
                [
                    'type' => 'Exam Review Request',
                    'content' => "Dear Admin,\n\nI hope this message finds you well. I am requesting a review of my recent Chemistry exam. There are specific concepts that I would like to discuss in detail. Could you please arrange a review session with the Chemistry teacher? I am available on Mondays and Wednesdays after 2:00 PM.\n\nThank you for your assistance.\n\nSincerely, Sophia Baker"
                ],
                [
                    'type' => 'Exam Review Request',
                    'content' => "Dear Admin,\n\nI hope this message finds you well. I am requesting a review of my recent History exam. There are specific topics that I would like to discuss in more detail. Could you please arrange a review session with the History teacher? I am available on Tuesdays and Thursdays after 3:00 PM.\n\nThank you for your assistance.\n\nSincerely, Zoe Brown"
                ],
            ],
            [
                [
                    'type' => 'Incident Report - Violent Behavior',
                    'content' => "Dear Admin,\n\nI am writing to report an incident of violent behavior that occurred on September 20th, involving a student altercation during recess. I believe it is important to address this matter promptly. Please let me know if you require any additional information.\n\nThank you for your attention.\n\nSincerely, Emily Johnson"
                ],
                [
                    'type' => 'Incident Report - Violent Behavior',
                    'content' => "Dear Admin,\n\nI regret to inform you of an incident of violent behavior that occurred on September 18th, involving a dispute between two students. I believe it is crucial to address this matter promptly and take appropriate action. Please let me know if you require any further details.\n\nThank you for your attention.\n\nSincerely, Ava Rodriguez"
                ],
                [
                    'type' => 'Incident Report - Violent Behavior',
                    'content' => "Dear Admin,\n\nI regret to inform you of an incident of violent behavior that occurred on September 16th, involving a disagreement between students. I believe it is imperative to address this matter promptly and take appropriate measures. Please let me know if you require any further information.\n\nThank you for your attention.\n\nSincerely, Mia Martinez"
                ],
            ],
            [
                [
                    'type' => 'Change Classroom Request',
                    'content' => "Dear Admin,\n\nI hope this message finds you well. I am writing to request a change in my classroom assignment. I believe that relocating to Classroom 203 would better facilitate my learning experience. Please consider my request and let me know if this can be arranged. Thank you for your attention to this matter.\n\nSincerely, John Doe"
                ],
                [
                    'type' => 'Change Classroom Request',
                    'content' => "Dear Admin,\n\nI am writing to request a change in my classroom assignment. Moving to Classroom 102 would better align with my learning needs. I appreciate your consideration of this request. Please inform me if this change can be arranged.\n\nBest regards, Alex Turner"
                ],
                [
                    'type' => 'Change Classroom Request',
                    'content' => "Dear Admin,\n\nI am writing to request a change in my classroom assignment. I believe that moving to Classroom 305 would better suit my learning style and preferences. Your consideration of this request is greatly appreciated. Please inform me if this adjustment is possible.\n\nBest regards, Noah Thompson"
                ],
                [
                    'type' => 'Change Classroom Request',
                    'content' => "Dear Admin,\n\nI am writing to request a change in my classroom assignment. I believe that moving to Classroom 401 would better support my learning needs. Your consideration of this request is greatly appreciated. Please inform me if this adjustment is possible.\n\nBest regards, Lucas Davis"
                ],
            ],
        ]
    ];

    public $feedbacks = [
        UserRole::TEACHER => [
            [
                [
                    'type' => 'Computer Usage Request',
                    'content' => "Thank you for your request to use the computer lab for your programming project. Your request has been approved for October 10th, from 2:00 PM to 4:00 PM. Please ensure compliance with all lab rules. Enjoy your work! Best, [Admin's Name]"
                ],
                [
                    'type' => 'Computer Usage Request',
                    'content' => "Thank you for your request to use the computer lab for your research project. Your request has been approved for November 3rd, from 1:00 PM to 3:00 PM. Please ensure compliance with all lab rules. Enjoy your work! Best, [Admin's Name]"
                ],
                [
                    'type' => 'Computer Usage Request',
                    'content' => "Thank you for your request to use the computer lab for your coding project. Your request has been approved for November 12th, from 10:00 AM to 12:00 PM. Please ensure compliance with all lab rules. Enjoy your work! Best, [Admin's Name]"
                ],
            ],
            [
                [
                    'type' => 'Service Usage Request',
                    'content' => "We have received your request to use the audiovisual equipment for your presentation. Your request has been approved for November 5th, from 3:00 PM to 5:00 PM. Please handle the equipment with care. Best regards, [Admin's Name]"
                ],
                [
                    'type' => 'Service Usage Request',
                    'content' => "We have received your request to use the photography equipment for your school project. Your request has been approved for December 8th, from 9:00 AM to 11:00 AM. Please handle the equipment with care. Best regards, [Admin's Name]"
                ],
                [
                    'type' => 'Service Usage Request',
                    'content' => "We have received your request to use the sound equipment for your music performance. Your request has been approved for December 20th, from 5:00 PM to 7:00 PM. Please handle the equipment with care. Best regards, [Admin's Name]"
                ],
            ],

            [
                [
                    'type' => 'Place Usage Request',
                    'content' => "Thank you for your request to use the school gymnasium for a basketball tournament. Your request has been approved for December 15th, from 9:00 AM to 12:00 PM. Please ensure the area is left in good condition. Best, [Admin's Name]"
                ],
                [
                    'type' => 'Place Usage Request',
                    'content' => "Thank you for your request to use the school auditorium for a drama rehearsal. Your request has been approved for October 28th, from 4:00 PM to 7:00 PM. Please ensure the area is left in good condition. Best, [Admin's Name]"
                ],
                [
                    'type' => 'Place Usage Request',
                    'content' => "Thank you for your request to use the outdoor basketball court for a friendly match. Your request has been approved for October 5th, from 3:00 PM to 5:00 PM. Please ensure the area is left in good condition. Best, [Admin's Name]"
                ],
            ],
        ],
        UserRole::STUDENT => [
            [
                [
                    'type' => 'Exam Review Request',
                    'content' => "We appreciate your interest in reviewing your recent Mathematics exam. We will coordinate with the respective teacher to schedule a review session. You will receive further details shortly. Thank you for your patience. Regards, [Admin's Name]"
                ],
                [
                    'type' => 'Exam Review Request',
                    'content' => "We appreciate your interest in reviewing your recent Biology exam. We will coordinate with the respective teacher to schedule a review session. You will receive further details shortly. Thank you for your patience. Regards, [Admin's Name]"
                ],
                [
                    'type' => 'Exam Review Request',
                    'content' =>  "We appreciate your interest in reviewing your recent Chemistry exam. We will coordinate with the respective teacher to schedule a review session. You will receive further details shortly. Thank you for your patience. Regards, [Admin's Name]"
                ],
                [
                    'type' => 'Exam Review Request',
                    'content' => "We appreciate your interest in reviewing your recent History exam. We will coordinate with the respective teacher to schedule a review session. You will receive further details shortly. Thank you for your patience. Regards, [Admin's Name]"
                ],
            ],
            [
                [
                    'type' => 'Incident Report - Violent Behavior',
                    'content' => "We appreciate your prompt reporting of the incident. We will investigate the matter and take appropriate action. Your commitment to maintaining a safe environment is valued. Thank you for your cooperation. Regards, [Admin's Name]"
                ],
                [
                    'type' => 'Incident Report - Violent Behavior',
                    'content' => "We appreciate your prompt reporting of the incident. We will investigate the matter and take appropriate action. Your commitment to maintaining a safe environment is valued. Thank you for your cooperation. Regards, [Admin's Name]"
                ],
                [
                    'type' => 'Incident Report - Violent Behavior',
                    'content' => "We appreciate your prompt reporting of the incident. We will investigate the matter and take appropriate action. Your commitment to maintaining a safe environment is valued. Thank you for your cooperation. Regards, [Admin's Name]"
                ],
            ],
            [
                [
                    'type' => 'Change Classroom Request',
                    'content' => "Thank you for submitting your request for a change in classroom assignment. We will review your request and inform you of any updates. Please be patient as we evaluate the feasibility of the change. Best regards, [Admin's Name]"
                ],
                [
                    'type' => 'Change Classroom Request',
                    'content' => "Thank you for submitting your request for a change in classroom assignment. We will review your request and inform you of any updates. Please be patient as we evaluate the feasibility of the change. Best regards, [Admin's Name]"
                ],
                [
                    'type' => 'Change Classroom Request',
                    'content' => "Thank you for submitting your request for a change in classroom assignment. We will review your request and inform you of any updates. Please be patient as we evaluate the feasibility of the change. Best regards, [Admin's Name]"
                ],
                [
                    'type' => 'Change Classroom Request',
                    'content' => "Thank you for submitting your request for a change in classroom assignment. We will review your request and inform you of any updates. Please be patient as we evaluate the feasibility of the change. Best regards, [Admin's Name]"
                ],
            ],
        ]
    ];

    public function definition(): array
    {
        $this->setInjection([FactoryService::class]);

        $status = $this->factoryService->getValidValue($this->statuses, $this->statusRanges, range(0, 2));
        $this->statuses[] = $status;

        $randomUser = User::whereNot('role', UserRole::ADMIN)->inRandomOrder()->first();
        $type = random_int(0, 2);
        $feedback = $status == Insistence::PENDING ? '' : $this->factoryService->randValues($this->feedbacks[$randomUser->role][$type])['content'];

        return [
            'user_id' => $randomUser->id,
            'content' => $this->factoryService->randValues($this->insistencesContent[$randomUser->role][$type])['content'],
            'feedback' => $feedback,
            'status' => $status,
            'type' => InsistenceTypes::NORMAL
        ];
    }
}
