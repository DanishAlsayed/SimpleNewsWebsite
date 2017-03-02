CREATE TABLE comments (
commentID int(11) NOT NULL,
newsID int(11) NOT NULL,
userID int(11) NOT NULL,
content longtext NOT NULL,
time varchar(30) NOT NULL,
PRIMARY KEY (commentID)
);
INSERT INTO comments(commentID, newsID , userID, content, time)
VALUES (
'1',
'5',
'1',
'Fantastic!',
'Oct 13 2016'
);
INSERT INTO comments(commentID, newsID , userID, content, time)
VALUES (
'2',
'10',
'2',
'Great!',
'Oct 14 2016'
);
INSERT INTO comments(commentID, newsID , userID, content, time)
VALUES (
'3',
'15',
'3',
'Bad!',
'Oct 15 2016'
);