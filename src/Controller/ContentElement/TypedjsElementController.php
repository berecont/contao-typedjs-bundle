<?php

declare(strict_types=1);

/*
 * This file is part of Typedjs.
 * 
 * (c) Bernhard Renner <info@berecont.at>
 * @license GPL-3.0-or-later
 * For the full copyright and license information,
 * please view the LICENSE file that was distributed with this source code.
 * @link https://github.com/berecont/contao-typedjs-bundle
 */

namespace Berecont\ContaoTypedjsBundle\Controller\ContentElement;

use Contao\ContentModel;
use Contao\CoreBundle\Controller\ContentElement\AbstractContentElementController;
use Contao\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RequestStack;
use Netzmacht\Contao\Toolkit\View\Template\BackendTemplate;

/**
 * Class TypedjsElementController
 */
class TypedjsElementController extends AbstractContentElementController
{
    /**
     * Generate the content element
     */
    protected function getResponse(Template $template, ContentModel $model, Request $request): Response
    {
        // Check if the current scope is backend        
        if ($request->attributes->get('_scope') === 'backend') {
            // Use the backend template
            $backendTemplate = new BackendTemplate('be_typedjs_element');
            $backendTemplate->wildcard = '<p>' . $model->elementParagraph . '</p>' . $model->elementStrings;
            return new Response($backendTemplate->parse());
        } else {
            // Add the JavaScript and CSS file to the page
            $GLOBALS['TL_HEAD'][] = \Contao\Template::generateScriptTag('bundles/berecontcontaotypedjs/typed.umd.js', false, null);
            $GLOBALS['TL_HEAD'][] = \Contao\Template::generateInlineStyle('bundles/berecontcontaotypedjs/typedjs.css');

            // Set the frontend text from the model
            $template->elementStrings = \Contao\StringUtil::decodeEntities($model->elementStrings);
            $template->elementOptions = json_decode($model->elementOptions, true);
            $template->elementId = $model->elementId;
            $template->elementTypespeed = $model->elementTypespeed;
            $template->elementParagraph = \Contao\StringUtil::decodeEntities($model->elementParagraph);
        }

        return $template->getResponse();
    }
}