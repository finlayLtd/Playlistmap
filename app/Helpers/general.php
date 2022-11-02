<?php


function _active_menu($route, $parent = false)
{
    $route_name = request()->route()->getName();
    $route_group = explode('.', $route_name)[0];
    if ($parent)
        return $route_group == $route ? ' open' : '';
    else
        return $route_name == $route ? ' active' : '';
}

function _selected($current, $old, $field, $relation = null)
{
    $relation = $relation ?? $field;
    return in_array($current->id, old($field, $old ? $old->{$relation}->pluck('id')->toArray() : array())) ? 'selected' : '';
}

function _active_group_section($section)
{
    $section = lcfirst($section);
    return request()->is("groups/*/$section/*") || request()->is("groups/*/$section") ? 'bg-primary text-white' : '';
}

function _sidebar_menu($route, $text)
{
    $class = $route == request()->url() ? 'active' : '';
    return '<li><a class="' . $class . '" href="' . $route . '">' . $text . '</a></li>';
}

function _sidebar_menu_group($text, $icon)
{
    return
        '<a class="nav-submenu" data-toggle="nav-submenu" href="#">
            <i class="' . $icon . '"></i><span class="sidebar-mini-hide">' . $text . '</span>
        </a>';
}

function replaceSingleQoutes($string)
{
    return str_replace(["'"], ["\""], $string);
}

function replaceDoubleQoutes($string)
{
    return str_replace(["\""], ["'"], $string);
}

function kConverter($num) {

    if($num>1000) {

        $x = round($num);
        $x_number_format = number_format($x);
        $x_array = explode(',', $x_number_format);
        $x_parts = array('K', 'M', 'B', 'T');
        $x_count_parts = count($x_array) - 1;
        $x_display = $x;
        $x_display = $x_array[0] . ((int) $x_array[1][0] !== 0 ? '.' . $x_array[1][0] : '');
        $x_display .= $x_parts[$x_count_parts - 1];

        return $x_display;

    }

    return $num;
}


