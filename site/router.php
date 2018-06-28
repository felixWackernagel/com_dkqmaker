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

        $vars['view'] = $segments[0];
        if( isset( $segments[1] ) )
		{
            if( $segments[0] == 'quiz' )
            {
                $vars['quiz'] = $segments[1];
            }
            else
            {
                $vars['id'] = $segments[1];
            }
		}
		else
        {
            if( $segments[0] == 'quiz' )
            {
                $vars['view'] = 'quizzes';
            }
        }

        if( isset( $segments[2] ) && $segments[2] == 'question' )
        {
            $vars['view'] = 'questions';
            if( isset( $segments[3] ) )
            {
                $vars['view'] = 'question';
                $vars['question'] = $segments[3];
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
