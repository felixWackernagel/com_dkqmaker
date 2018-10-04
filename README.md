# com_dkqmaker
Joomla component to create quizzes with questions and popuate over a api.

## URLs
Each deprecated url will be removed in the future.

### Get an array of quiz objects without questions
/quiz (deprecated)  
/quizzes (deprecated)  
/v1/quizzes

### Get a quiz object with questions
/quiz/{quiz-number} (deprecated)  
/quizzes/{quiz-number} (deprecated)  
/v1/quizzes/{quiz-number}

### Get an array of questions from a concrete quiz
/quiz/{quiz-number}/question (deprecated)  
/quizzes/{quiz-number}/questions (deprecated)  
/v1/quizzes/{quiz-number}/questions

### Get a question object from a concrete quiz
/quiz/{quiz-number}/question/{question-number} (deprecated)  
/quizzes/{quiz-number}/questions/{question-number} (deprecated)  
/v1/quizzes/{quiz-number}/questions/{question-number}

### Get an array of messages
/messages (deprecated)  
/v1/messages

### Get a message object
/messages/{message-number} (deprecated)  
/v1/messages/{message-number}

### Check the version number against the current playstore version
/versions/{version-number} (deprecated)  
/v1/versions/{version-number}

### Get an array of quizzers
/quizzers (deprecated)  
/quizzers

### Get a quizzer object
/quizzers/{quizzer-number} (deprecated)  
/v1/quizzers/{quizzer-number}
