<?php


namespace App\Library;


use App\Language;
use Google\ApiCore\ApiException;
use Google\ApiCore\ValidationException;
use Google\Cloud\TextToSpeech\V1\AudioConfig;
use Google\Cloud\TextToSpeech\V1\AudioEncoding;
use Google\Cloud\TextToSpeech\V1\SynthesisInput;
use Google\Cloud\TextToSpeech\V1\TextToSpeechClient;
use Google\Cloud\TextToSpeech\V1\VoiceSelectionParams;

class TextToSpeech
{
    /**
     * @param Language $language
     * @param $text
     * @return string
     * @throws ApiException
     * @throws ValidationException
     */
    public static function synthesizeSpeech(Language $language, $text)
    {
        $speechSettings = $language->textToSpeechSettings;

        // instantiates a client
        $client = new TextToSpeechClient([
            'credentialsConfig' => [
                'keyFile' => [
                    "type" => "service_account",
                    "project_id" => "yummy-lingo",
                    "private_key_id" => "276e252ae82583e926f74cffcc1878b9873e8a65",
                    "private_key" => "-----BEGIN PRIVATE KEY-----\nMIIEvQIBADANBgkqhkiG9w0BAQEFAASCBKcwggSjAgEAAoIBAQCXA17w4V254x4A\nkgszaZocti7pjt1vUO4G2uRFxiP5kyoBQoXakabGoDi3rjbJ77ir21wKzbMiUQtV\n2hCHvh7c+w6NWomd54xb/XPu26FNjCURL+2INUQ4l3LJXJY43jTc4BfI7rtvDS4m\nGWIZfkM+ruz/VKtmdm/MfP6Inr7oU0rgihIzrPHkzVDzMRc1crPMurDfMrXu+mNp\nNWwby90awsNojz3yXLcphnRmFQjV43uce9z3zDIuZ0ewrlTP2XmxqZnLWrckAm2R\n7laZFGRE3srd7TP0j1CRzSL7gXt/HgZczE54fX0rt06qHJbsb4XrnxwwBEPoFQEn\nwnzybXP3AgMBAAECggEAFcjIs1rvWFdpBpAKyZncP3QQhGS1kM9N5vNApsgUfHY8\nQv5DrOoB8vk99VFOWgcYzsHQH0bZJoQmbHYOmGZWsW4OBVogLAUw/DwtszE/rZ4f\n4sDVNSbp9nfyeRXAHegAHDS/eZ7mrvhpxdk3i5HpRWuaiKLALwG60vbdCPxNcdoJ\nV8igZNHtl5cpVA66aUdC5V3zKotdmeBUSUCLAHcJFGGTVT8uHljTJyHOWf4oUGco\nPRrQlqZfIdVpGSSHxUTfCYotPyMFp+SKM/P6dkA7HXhKQ9VygWzb3tAbrwXkRQIe\n0VmlLXB9cMyjZ3+jpUPVjO+2/UWOOq68QvSgScYQwQKBgQDMee/Ixe9ECWbuY+HO\nimJGoK8/pM/TplgzRop4fJuLbHlIYaN6VC7CnutPgYjf7RAUMFInwZeAkci01W4M\n9Zp3Dt7iRslrzk6QAxa89wft6dBBZ2RRqENMPm/zgCUgaHpdw0ZCVza0e2A5OlPo\n2Yz8smfGkATL+yomnjD44Fpb5wKBgQC9ELXm7qA04iYvIb+lmfWdMTiKZc5F8/zz\nYfRvj1HaxJT7roXbn0qQTEyvRO7hMMK0zkROpya6KbzgVxBhlR/cm0kLNX243psq\n053biSv/tLPip/zhB19Q27tZ2y0KsfNvv8zQ9hF4OxaTx/oz3wRA9Q1rQtVLL3M/\n35mNNlmlcQKBgQC8duNY5X8r8ZKKxUsaaJg+StpcSdc4WAjRcgItHYTsVBXRbhUU\nqkTTI1D13gm/gywfv43pkNjIKxaX/mRJ05IEjJNIckAyelwVBpPNpc8MLUbDEb34\nOaOVwbLD9+fAYCvxAgxfFy2X2mONO8KdSu9U9kcKUDHrpNtr7sBqk7cVHwKBgB5J\nxgpX4hx2uk1Ep9IcxwdGslshkhkMzFIlOCaDHEbixUdInzMe4rAZORO/BFHZIOgc\nPz8mcgLS2upJqFspq7AIxHviNuDd8Je8zQY1hHHzffnqlY1rQ+7NNMdhYGbdOTWG\n0YYMVaIgPS6xk7ipmqHZYCv1yfvAf0MVTCEeOuBRAoGATvB9YpaYWYYmQnFo8wQV\n3HEWjpjakfeoKl5j0ZPvwV4fkUvRc1tYf+pJIwr7RVa4WcVRmO1HbRHEGC56k6kn\nNTo/Xhr0OsH5aYMRMGYWL+jkNxLNv04O/tQqMqBElVQdMdRNHFM/QMrEa3eLb6H8\nWrPA5Ym4bmUTPtoAL2MSsOk=\n-----END PRIVATE KEY-----\n",
                    "client_email" => "text-to-speech@yummy-lingo.iam.gserviceaccount.com",
                    "client_id" => "110233744392045106454",
                    "auth_uri" => "https://accounts.google.com/o/oauth2/auth",
                    "token_uri" => "https://oauth2.googleapis.com/token",
                    "auth_provider_x509_cert_url" => "https://www.googleapis.com/oauth2/v1/certs",
                    "client_x509_cert_url" => "https://www.googleapis.com/robot/v1/metadata/x509/text-to-speech%40yummy-lingo.iam.gserviceaccount.com"
                ],
            ],
        ]);

        // sets text to be synthesised
        $synthesisInputText = (new SynthesisInput())
            ->setText($text);

        $voice = (new VoiceSelectionParams())
//            ->setName($speechSettings->voice_name);
//            ->setLanguageCode($language->code)
            ->setLanguageCode('ru-RU')
//            ->setName('en-US-Wavenet-D');
        ->setName('ru-RU-Wavenet-E');

        // Effects profile
        $effectsProfileId = "headphone-class-device";

        // select the type of audio file you want returned
        $audioConfig = (new AudioConfig())
            ->setAudioEncoding(AudioEncoding::LINEAR16)
            ->setSampleRateHertz(24000)
//            ->setPitch($speechSettings->pitch)
            ->setPitch(0)
//            ->setSpeakingRate($speechSettings->speaking_rate)
            ->setSpeakingRate(1)
            ->setEffectsProfileId(array($effectsProfileId));

        // perform text-to-speech request on the text input with selected voice
        // parameters and audio file type
        $response = $client->synthesizeSpeech($synthesisInputText, $voice, $audioConfig);

        return $response->getAudioContent();
    }
}
