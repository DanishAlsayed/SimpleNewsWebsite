Readme.txt

index.html

This is the start off file. It consists of javascript and html only. Javascript is at the top. It has the functions loadNewsList(pageindex) and logout()
as instructed as well as the functions printNews(jsonArray, newsCount)and pageIndexing(newsCount) to handle printing the news list and the index
at the bottom.

displayNewsEntry.php

The file that handles the display of a single news entry. It has one large javascript function at the top of the file called postComment(lastCommentID, newsID)
that posts new comments. The rest is php in the file that prints the html display.

handlePostComment.php

This is a pure php file that handles the server-side processing of displaying and entring new comments. It sends comments as a JSON.

handleListDisplay.php

Another pure php file that handles the server-side processing of displaying the news list. It has a php function called etSimplifiedContent($content,$words_number)
that shortens the news content to 10 words as instructed. Also uses JSON to send the processed news entries for the list display.

handleLogin.php

Pure php. Logs in users if their username and password match an entry in the users table.

handleLogout.php

Unsets the userID cookie.

login.php

A "mixed" file with  php, html and javascript. A javascript function login() is there that retrieves the username and password and handles the
communication with handleLogin.php. It also had php that prints html.

style.css

Has that styling for the above pages.