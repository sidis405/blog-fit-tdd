<?php
function create($model, $howMany = null, $attributes = [])
{
    return factory($model, $howMany)->create($attributes);
}

function make($model, $howMany = null, $attributes = [])
{
    return factory($model, $howMany)->make($attributes);
}
