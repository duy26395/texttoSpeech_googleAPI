<?php

class texttospeech
{
    private $connect;
    protected $textinput = null;
    protected $namevoid = null;
    protected $languageCode = null;
    protected $voidgender = null;
    protected $hzvoid = null;

    public function __construct($response,$textToSpeechClient,$input,$voice,$audioConfig)
    {
        $this->response = $response;
        $this->textToSpeechClient = $textToSpeechClient;
        $this->input = $input;
        $this->voice = $voice;
        $this->audioConfig = $audioConfig;

    }
    public function textinput($textinput)
    {
        $this->textinput = $textinput;
        return $this->textinput;
    }
    public function namevoid($namevoid)
    {
        $this->namevoid = $namevoid;
        return $this->namevoid;
    }
    public function viewnamevoid()
    {
        $data = array();
        foreach ($this->response as $voice) {
            array_push($data, $voice->getName());
        }
        return $data;
    }
    public function showaudio($textinputaudio,$languageaudio,$namevoidaudio)
    {   
        $this->input->setText($textinputaudio);
        $this->voice->setName($namevoidaudio);
        $this->voice->setLanguageCode($languageaudio);
        $resp = $this->textToSpeechClient->synthesizeSpeech($this->input, $this->voice, $this->audioConfig);
        $dir = "audio/";
        array_map('unlink', glob("{$dir}*.mp3"));
        return $resp->getAudioContent();
    }

}