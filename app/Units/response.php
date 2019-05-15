<?php

/**
 * 创建成功使用的状态码
 *
 * @param string $msg
 * @param array  $data
 * @param array  $extFields
 * @return \Illuminate\Http\JsonResponse
 */
function responseJsonAsCreated($msg = 'created success', $data = [], $extFields = [])
{
    return responseJson(201, $msg, $data, $extFields);
}

/**
 * 修改成功
 *
 * @param string $msg
 * @param array  $data
 * @param array  $extFields
 * @return \Illuminate\Http\JsonResponse
 */
function responseJsonAsDeleted($msg = 'deleted success', $data = [], $extFields = [])
{
    return responseJson(204, $msg, $data, $extFields);
}

/**
 * 表单验证错误使用
 *
 * @param string $msg
 * @param array  $data
 * @param array  $extFields
 * @return \Illuminate\Http\JsonResponse
 */
function responseJsonAsBadRequest($msg = 'bad request', $data = [], $extFields = [])
{
    return responseJson(400, $msg, $data, $extFields);
}


/**
 * 身份验证失败。
 *
 * @param string $msg
 * @param array  $data
 * @param array  $extFields
 * @return \Illuminate\Http\JsonResponse
 */
function responseJsonAsUnAuthorized($msg = 'un authorized', $data = [], $extFields = [])
{
    return responseJson(401, $msg, $data, $extFields);
}


/**
 * 用户身份过期, 需重新登录。
 *
 * @param string $msg
 * @param array  $data
 * @param array  $extFields
 * @return \Illuminate\Http\JsonResponse
 */
function responseJsonAsAccountExpired($msg = 'account expired', $data = [], $extFields = [])
{
    return responseJson(402, $msg, $data, $extFields);
}

/**
 * 权限不足
 *
 * @param string $msg
 * @param array  $data
 * @param array  $extFields
 * @return \Illuminate\Http\JsonResponse
 */
function responseJsonAsForbidden($msg = 'forbidden', $data = [], $extFields = [])
{
    return responseJson(403, $msg, $data, $extFields);
}


/**
 * 未找到使用 404
 *
 * @param string $msg
 * @param array  $data
 * @param array  $extFields
 * @return \Illuminate\Http\JsonResponse
 */
function responseJsonAsNoFound($msg = 'no found', $data = [], $extFields = [])
{
    return responseJson(404, $msg, $data, $extFields);
}


/**
 * 服务器未知错误
 *
 * @param string $msg
 * @param array  $data
 * @param array  $extFields
 * @return \Illuminate\Http\JsonResponse
 */
function responseJsonAsServerError($msg = 'server error', $data = [], $extFields = [])
{
    return responseJson(500, $msg, $data, $extFields);
}


/**
 * 正常状态使用
 *
 * @param int    $code
 * @param string $msg
 * @param array  $data
 * @param array  $extFields
 * @return \Illuminate\Http\JsonResponse
 */
function responseJson($code = 200, $msg = 'success', $data = [], $extFields = [])
{
    $responseData = compact('code', 'msg', 'data');
    $responseData = array_merge($responseData, $extFields);

    return response()->json($responseData);
}
