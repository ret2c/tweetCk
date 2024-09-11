## tweetCk
Simple PHP application where users can input a submission and have it be tweeted from my account.

This project is barely maintained, finished in about a day. Just wanted to create a cloud backup just in case I decide to take it further.
There are many opportunities for a user to abuse this app, shouldn't be anything to take serious :)

**9/11/2024**: This repository is archived, just a fun project for me and my friends so I could practice PHP :)

Utilizes [TwitterOAuth](https://github.com/abraham/twitteroauth-com) by [Abraham](https://github.com/abraham), which allows for simple execution:
![Sample code snippet for abraham\twitteroauth](https://i.ibb.co/xfrNbGk/carbon.png)<br>
Use composer (within same directory) to install:
```
composer require abraham\twitteroauth
```

Run locally to test/configure:
```
tweetCk [main] » php -S localhost:8000
#Navigate to http://localhost:8000, port number is arbitrary
```
