<?php

namespace App\Controller\Component;

use App\Model\Entity\Opcoes;
use Cake\Controller\Component;
use Cake\Core\Configure;
use Cake\Log\Log;
use Google\Cloud\RecaptchaEnterprise\V1\RecaptchaEnterpriseServiceClient;
use Google\Cloud\RecaptchaEnterprise\V1\Event;
use Google\Cloud\RecaptchaEnterprise\V1\Assessment;
use Google\Cloud\RecaptchaEnterprise\V1\CreateAssessmentRequest;

class UCaptchaComponent extends Component
{
    function ValidateToken($token)
    {
        $projectId = Configure::read("Recaptcha.ProjectId");
        $siteKey = Configure::read("Recaptcha.Key");        
        $credentials = json_decode(Opcoes::Ler("Recaptcha.Credentials"), true);

        Log::debug("[RECAPTCHA] User = " . $credentials['client_email']);

        $client = new RecaptchaEnterpriseServiceClient([
            'credentials' => $credentials
        ]);
        $project = $client->projectName($projectId);

        // Build the Event
        $event = new Event();
        $event->setToken($token);
        $event->setSiteKey($siteKey);

        // Create Assessment Request
        $assessment = new Assessment();
        $assessment->setEvent($event);

        $result = 'invalid_token';

        try {
            $response = $client->createAssessment($project, $assessment);

            if ($response->getTokenProperties()->getValid()) {
                $score = $response->getRiskAnalysis()->getScore();
                $minScore = floatval(Configure::read("Recaptcha.MinScore"));
                
                Log::debug("[Recaptcha] Request Score: ". $score);

                if ($score >= $minScore) {
                    $result = 'human';
                } else {
                    $result = 'bot';
                }
            } else {
                Log::error("[Recaptcha] Invalid token: " . $response->getTokenProperties()->getInvalidReason());
                $result = 'invalid_token';                
            }

        } catch (\Exception $e) {
            Log::error("[Recaptcha] Error when trying to validate: " . $e->__tostring());
            $result = 'error';
        }

        Log::debug("[Recaptcha] Request Result: ". $result);
        return $result;
    }
}

?>