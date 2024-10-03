<?php

function p_slugs()
{
    return auth()->user()->permissions()->pluck('slug')->toArray();
}
// permission check from view/blade
// check permission for single slug
function hasPermission ($slug, $permission_slugs)
{


    if (auth()->id() == 1) {
           return true;
    } else {
          return in_array($slug, $permission_slugs);
    }
}


// check permission for multiple slugs
function hasAnyPermission ($input_slugs, $permission_slugs)
{

    if (auth()->id() == 1) {
           return true;
    } else {
        if(count(array_intersect($permission_slugs, $input_slugs)) !== 0) {
            return true;
        } else {
            return false;
        }
    }
}


// check permission for single slug
function hasModulePermission ($module_name, $activae_modules)
{
    return in_array($module_name, $activae_modules);
}



