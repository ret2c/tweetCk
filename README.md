# 02/03/2023 Update:
Twitter is [suspending its free API access](https://twitter.com/TwitterDev/status/1621026986784337922) on 02/09/2023.<br>
This repository is now archived, was a fun project while it lasted. Thank you!

## tweetCky
Simple PHP application where users can input a submission and have it be tweeted from my account.

This project is barely maintained, finished in about a day. Just wanted to create a cloud backup just in case I decide to take it further.
There are many opportunities for a user to abuse this app, shouldn't be anything to take serious :)

Utilizes [TwitterOAuth](https://github.com/abraham/twitteroauth-com) by [Abraham](https://github.com/abraham), which allows for simple execution:
![Sample code snippet for abraham\twitteroauth](https://i.ibb.co/xfrNbGk/carbon.png)<br>
Use composer (within same directory) to install:
```
composer require abraham\twitteroauth
```

Run locally to test/configure:
```
tweetCky [main] » php -S localhost:8000
#Navigate to http://localhost:8000, port number is arbitrary
```
