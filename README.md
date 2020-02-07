# SlackApp
Slackapps is a simple PHP library to push message to Slack via Web API

## How to do it
- Goto and login https://api.slack.com/apps
- Click on **Create App** button
- A Model will open, give a name to app and select workspace.
- Set feature from **Add features and functionality**. Minimum Select *Incoming Webhooks*, *Interactive Components* and *Permission* features.
- Install your app to your workspace.
- Collect *App Credentials* and used it in your code.
- Run the script.

**Sample code example**
``` 
    $sa = new SlackApp();
    $sa->setPretext('Title')
        ->setColor('#000120')       
        ->setAuthorIcon('images/avatar/avatar-user.png') 
        ->setText('Description') 
        ->setActionUrl('URL to link') 
        ->setForSlackUser('!channel')
        ->send('https://hooks.slack.com/services/...');


Hope this might help you.
