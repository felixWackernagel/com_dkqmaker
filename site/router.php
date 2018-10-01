<?php
defined('_JEXEC') or die;

/*
 * It is required to have a Menu Item with type com_dkqmaker.
 * The Menu Item alias is the first segment in the url.
 * I.e. alias = api then is com_dkqmaker mounted on localhost/index.php/api/
 * Has the url more then the alias as segment then is parse() called.
 * I.e. localhost/index.php/api/quiz/1 has segment[0] = quiz and segment[1] = 1.
 * The Menu Item musst be published.
 */
class DKQMakerRouter extends JComponentRouterBase
{
	public function build(&$query)
	{
        // Looks like unused because no user friendly url must be created from the system.
		$segments = array();
		return $segments;
	}

	public function parse(&$segments)
	{
		$vars = array();

		$startIndex = 0;

		$segmentOne = $segments[$startIndex];
        $segmentOneLength = strlen( $segmentOne );
		if( substr( $segmentOne, 0, 1 ) == 'v' ) {
            $startIndex = 1;
            $vars['v'] = substr( $segmentOne, 1, $segmentOneLength );
        }

        $vars['view'] = $segments[$startIndex];
        if( isset( $segments[$startIndex + 1] ) )
		{
            // ../quiz/5
            if( $segments[$startIndex] == 'quiz' || $segments[$startIndex] == 'quizzes' )
            {
                $vars['view'] = 'quizzes';
                $vars['quiz'] = $segments[$startIndex+1];
            }
            else
            {
                $vars['id'] = $segments[$startIndex+1];
            }
		}
		else
        {
            if( $segments[$startIndex] == 'quiz' )
            {
                // ../quiz
                $vars['view'] = 'quizzes';
            }
        }

        if( isset( $segments[$startIndex+2] ) && ( $segments[$startIndex+2] == 'question' || $segments[$startIndex+2] == 'questions' ) )
        {
            // ../quiz/5/question
            $vars['view'] = 'questions';
            if( isset( $segments[$startIndex+3] ) )
            {
                // ../quiz/5/question/4
                $vars['view'] = 'questions';
                $vars['question'] = $segments[$startIndex+3];
            }
        }
		return $vars;
	}
}

function dkqmakerBuildRoute(&$query)
{
	$router = new DKQMakerRouter;
	return $router->build($query);
}

function dkqmakerParseRoute($segments)
{
	$router = new DKQMakerRouter;
	return $router->parse($segments);
}
