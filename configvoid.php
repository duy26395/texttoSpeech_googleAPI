<?php
require __DIR__ . '/vendor/autoload.php';
use Google\Cloud\TextToSpeech\V1\AudioConfig;
use Google\Cloud\TextToSpeech\V1\AudioEncoding;
use Google\Cloud\TextToSpeech\V1\SsmlVoiceGender;
use Google\Cloud\TextToSpeech\V1\SynthesisInput;
use Google\Cloud\TextToSpeech\V1\TextToSpeechClient;
use Google\Cloud\TextToSpeech\V1\VoiceSelectionParams;
putenv('GOOGLE_APPLICATION_CREDENTIALS=google.json');
// create client object
$client = new TextToSpeechClient();
$input = new SynthesisInput();
$voice = new VoiceSelectionParams();
$audioConfig = new AudioConfig();
$audioConfig = $audioConfig->setAudioEncoding(AudioEncoding::MP3);

// perform list voices request
$response = $client->listVoices();
$voices = $response->getVoices();

include_once 'void-master.php';

$texttospeech = new texttospeech($voices,$client,$input,$voice,$audioConfig);


