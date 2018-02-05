<?php

if (!function_exists('checkActiveRoutes')) {

    /**
     * Active menu side bar when routes menu are current route
     *
     * @param Array  $routes routes action
     * @param string $output active or ''
     *
     * @return string
     */
    function checkActiveRoutes(array $routes, $output = "active")
    {
        if (in_array(Route::currentRouteName(), $routes, true)) {
            return $output;
        }
    }
}

/**
 * Display multilevel comments in post detail
 *
 * @param array  $comments comments
 * @param int    $parentId parent id
 * @param string $char     char for subComment
 *
 * @return string
 */
function showComment($comments, $parentId = null, $char = '')
{
    $body = '';

    foreach ($comments as $comment) {
        if ($comment->parent_id == $parentId) {
            $body .= '<tr>';
                $body .= '<td>'.$char.$comment->comment.'</td>';
                $body .= '<td class="text-center">'.$comment->created_at.'</td>';
                $body .= '<td class="text-center" width="15%">';
                $body .= '<a href="#" class="btn btn-danger btn-flat fa fa-trash-o btn-delete-item"';
                    $body .= 'data-title="{{ __("common.confirm.title") }}"';
                    $body .= 'data-confirm="{{ __("common.confirm.delete_comment") }}">';
                $body .= '</a>';
                $body .= '</td>';
            $body .= '</tr>';
            $body .= showComment($comments, $comment->id, $char.'&nbsp;&nbsp;<i class="fa fa-long-arrow-right"></i>&nbsp;&nbsp;');
        }
    }
    return $body;
}
