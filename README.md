# com_dkqmaker
Joomla component to create quizzes with questions and popuate over a api.

## URLs

### Get an array of quiz objects without questions
/quiz (deprecated)
/quizzes

### Get a quiz object with questions
/quiz/{quiz-number} (deprecated)
/quizzes/{quiz-number}

### Get an array of questions from a concrete quiz
/quiz/{quiz-number}/question (deprecated)
/quizzes/{quiz-number}/questions

### Get a question object from a concrete quiz
/quiz/{quiz-number}/question/{question-number} (deprecated)
/quizzes/{quiz-number}/questions/{question-number}

### Get an array of messages
/messages

### Get a message object
/messages/{message-number}

### Get an array of key-value pairs
/configs

### Get an array of quizzers
/quizzers

### Get a quizzer object
/quizzers/{message-number}
