# Instagram Video Downloader Bot

This is a simple **Telegram bot** that allows you to download **Instagram videos** by sending an Instagram link. The bot takes your Instagram URL and provides you with a download link.

### Features:
- **Instagram Video Downloader**: Send an Instagram video URL and get a custom download link.
- **Simple Command**: Just type `/start` to get started.
- **Fast Processing**: Converts Instagram links into downloadable content quickly.

### Prerequisites:
Before using this bot, you will need:
- A **Telegram Bot Token** (Get it from [BotFather](https://core.telegram.org/bots#botfather)).
- **PHP** installed on your system (Version 7.0 or higher).

### Setup Instructions:

1. **Clone the Repository** :
   Clone the GitHub repository
   
   ```bash
   git clone https://github.com/Siryadav/insta-downloader.git
   ```

2. **Get Your Bot Token**:

Go to BotFather on Telegram.

Create a new bot and copy the bot token you get.


3. **Set Up the Bot In the config.php file**:

Open the config.php file.

Find this line in the file:

```bash
$token = "YOUR_BOT_TOKEN";  // Replace with your Telegram Bot token
```
Replace YOUR_BOT_TOKEN with your actual Telegram bot token you got from BotFather.



4. **Run the Script**:

Run the script with PHP:
```bash
php insta.php
```
