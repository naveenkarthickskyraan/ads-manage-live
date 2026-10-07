<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link href="{{ asset('assets/img/skyraan-technologies.avif') }}" rel="icon">

    <title>Ads Manager - Version 1 [Dev-APIs] - Webservice Form</title>

    <style type="text/css">
        body {
            font-size: 13px;
        }
    </style>

</head>

<body>
    {{-- <fieldset>
            <form name="form" method="GET" action="{{url('/api/app_list_api')}}"> 
            @csrf
            <input type="hidden" name="_token" value="poyVeWVAWoGXuKZxeCgQYlaYdOvUxCoQKczaj36T">           
            <table  border="0" width="100%">
            <tr>
                <td height="30" colspan="2" align="left"> <strong style="text-decoration:underline;color:#F00;"> 1 . App List [ Development Mode ] </strong><br>
                    <div><strong>API URL:</strong> {{ url('/api/app_list_api')}}</div>
                    <div><strong>Method:</strong> GET </div>
                    <div><strong>Content-Type:</strong> application/x-www-form-urlencoded [i.e. x-www-form-urlencoded]</div>
                    <div><strong>API Mode:</strong> Development </div>
                    <div><strong>Notes:</strong> Last Modified at : 06-Oct-2022 </div>
                </td>
            </tr>
            <tr>
                <td colspan="2" align="center">
                    <table width="100%" border="0" cellspacing="2" cellpadding="2">
                        <tr style="background-color:#162133;  color:#FFF;">
                            <td><strong>Label Name</strong></td>
                            <td><strong>Value</strong></td>
                            <td><strong>Variable Name</strong></td>
                            <td><strong>Mandatory</strong></td>
                            <td><strong>Note</strong></td>
                            <td><strong>Sample</strong></td>
                        </tr>
                        <tr>
                            <td colspan="1" align="center"><input type="submit" value="Submit"/></td>
                        </tr>
                    
                    </table>
                </td>
            </tr>
            </table>
        </form>
    </fieldset>
    <br><br> --}}

    <fieldset>
        <form name="form" method="POST" action="{{ url('api/get_ads_list_by_package_name') }}">
            @csrf
            <input type="hidden" name="_token" value="poyVeWVAWoGXuKZxeCgQYlaYdOvUxCoQKczaj36T">
            <table border="0" width="100%">
                <tr>
                    <td height="30" colspan="2" align="left"> <strong
                            style="text-decoration:underline;color:#F00;"> 1 .Get Ads List by Package Name And App Type
                            [ Development Mode ] </strong><br>
                        <div><strong>API URL:</strong> {{ url('api/get_ads_list_by_package_name') }}</div>
                        <div><strong>Method:</strong> POST </div>
                        <div><strong>Content-Type:</strong> application/x-www-form-urlencoded [i.e.
                            x-www-form-urlencoded]</div>
                        <div><strong>API Mode:</strong> Development </div>
                        <div><strong>Notes:</strong> Last Modified at : 06-Oct-2022 </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" align="center">
                        <table width="100%" border="0" cellspacing="2" cellpadding="2">
                            <tr style="background-color:#162133;  color:#FFF;">
                                <td><strong>Label Name</strong></td>
                                <td><strong>Value</strong></td>
                                <td><strong>Variable Name</strong></td>
                                <td><strong>Mandatory</strong></td>
                                <td><strong>Note</strong></td>
                                <td><strong>Sample</strong></td>
                            </tr>

                            <tr>
                                <td>Package Name</td>
                                <td><input type="text" name="package_name" /></td>
                                <td>package_name</td>
                                <td>Yes</td>
                                <td>From Ads List API </td>
                                <td>1 (string)</td>
                            </tr>
                            <tr>
                                <td>App Type</td>
                                <td><input type="number" name="app_type" /></td>
                                <td>app_type</td>
                                <td>Yes</td>
                                <td>From Font List API</td>
                                <td>1 (Android) or 2 (IOS)</td>
                            </tr>
                            <tr>
                                <td colspan="1" align="center"><input type="submit" value="Submit" /></td>
                            </tr>

                        </table>
                    </td>
                </tr>
            </table>
        </form>
    </fieldset>
    <br><br>


    <fieldset>
        <form name="form" method="POST" action="{{ url('api/get_priority_ads') }}">
            @csrf
            <input type="hidden" name="_token" value="poyVeWVAWoGXuKZxeCgQYlaYdOvUxCoQKczaj36T">
            <table border="0" width="100%">
                <tr>
                    <td height="30" colspan="2" align="left"> <strong
                            style="text-decoration:underline;color:#F00;"> 2 .Get Priority Ads List by packagename And App Type
                            [ Development Mode ] </strong><br>
                        <div><strong>API URL:</strong> {{ url('api/get_priority_ads') }}</div>
                        <div><strong>Method:</strong> POST </div>
                        <div><strong>Content-Type:</strong> application/x-www-form-urlencoded [i.e.
                            x-www-form-urlencoded]</div>
                        <div><strong>API Mode:</strong> Development </div>
                        <div><strong>Notes:</strong> Last Modified at : 06-Oct-2022 </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" align="center">
                        <table width="100%" border="0" cellspacing="2" cellpadding="2">
                            <tr style="background-color:#162133;  color:#FFF;">
                                <td><strong>Label Name</strong></td>
                                <td><strong>Value</strong></td>
                                <td><strong>Variable Name</strong></td>
                                <td><strong>Mandatory</strong></td>
                                <td><strong>Note</strong></td>
                                <td><strong>Sample</strong></td>
                            </tr>

                            <tr>
                                <td>Package Name</td>
                                <td><input type="text" name="package_name" /></td>
                                <td>package_name</td>
                                <td>Yes</td>
                                <td>From Ads List API </td>
                                <td>1 (string)</td>
                            </tr>
                            <tr>
                                <td>App Type</td>
                                <td><input type="number" name="app_type" /></td>
                                <td>app_type</td>
                                <td>Yes</td>
                                <td>From Font List API</td>
                                <td>1 (Android) or 2 (IOS)</td>
                            </tr>
                            <tr>
                                <td colspan="1" align="center"><input type="submit" value="Submit" /></td>
                            </tr>

                        </table>
                    </td>
                </tr>
            </table>
        </form>
    </fieldset>
    <br><br>

</body>

</html>
