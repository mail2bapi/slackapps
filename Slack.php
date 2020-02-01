<?php


namespace slackapp;


class Slack
{
    private $error;
    private $fallback;
    private $color;
    private $pretext;
    private $author_name;
    private $author_icon;
    private $title;
    private $description; // Description
    private $slackUser;
    private $slackAppUrl;

    //Slack Action
    private $action_type;
    private $action_text;
    private $action_url;
    private $action_style;

    public function __construct()
    {
        //Default Values
        $this->error = '';
        $this->fallback = '';
        $this->color = '#36a64f';
        $this->action_type = 'button';
        $this->action_style = 'primary';
        $this->action_text = 'View Detail';
        $this->action_url = '';
        $this->slackUser = '!channel';
    }

    /**
     * Send the message to SLACK
     * Refer - https://api.slack.com/tutorials/slack-apps-hello-world
     */
    public function send(){
        if(!empty($this->slackAppUrl)){
            $this->fallback = $this->description;

            $ch = curl_init($this->slackAppUrl);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type'=>'application/json']);
            curl_setopt(
                $ch,
                CURLOPT_POSTFIELDS,
                $this->preparePostData() // JSON data for SLACK API
            );

            $response = curl_exec($ch);
            if(curl_error($ch) === false){
                $this->error = "SLACK APP ERROR: ".$response." - ".curl_error($ch);
            }
            curl_close($ch);

        }
    }

    /**
     * Give json string for curl post
     * @return JSON string
     */
    private function preparePostData(){
        $postData = [
            "attachments" => [[
                "fallback" => $this->fallback,
                "color" => $this->color,
                "pretext" => $this->pretext.' '.$this->slackUser,
                "author_name" => $this->author_name,
                "author_icon" => $this->author_icon,
                "title" => $this->title,
                "text" => $this->description,
                "actions" => [[
                    "type" => $this->action_type,
                    "text" => $this->action_text,
                    "url" => $this->action_url,
                    "style" => $this->action_style
                ]],
            ]]
        ];
        return json_encode($postData);
    }

    public function setFallback($fallback)
    {
        $this->fallback = $fallback;
        return $this;
    }

    public function setColor($color)
    {
        $this->color = $color;
        return $this;
    }

    public function setPretext($pretext)
    {
        $this->pretext = $pretext;
        return $this;
    }

    public function setAuthorName($author_name)
    {
        $this->author_name = $author_name;
        return $this;
    }

    public function setAuthorIcon($author_icon)
    {
        $this->author_icon = $author_icon;
        return $this;
    }

    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    public function setDescription($text)
    {
        $this->description = "_".htmlspecialchars($text)."_";
        return $this;
    }

    public function setActionType($action_type)
    {
        $this->action_type = $action_type;
        return $this;
    }

    public function setActionText($action_text)
    {
        $this->action_text = $action_text;
        return $this;
    }

    public function setActionUrl($action_url)
    {
        $this->action_url = $action_url;
        return $this;
    }

    public function setActionStyle($action_style)
    {
        $this->action_style = $action_style;
        return $this;
    }

    public function setSlackUser(array $forSlackUser)
    {
        $users = explode(' ', $forSlackUser);
        foreach ($users as $user) {
            $this->slackUser .= ' <'.$user.'>';
        }
        return $this;
    }
}