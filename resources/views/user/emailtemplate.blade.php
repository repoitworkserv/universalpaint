<table width="100%" height="100%" style="min-width:348px" border="0" cellspacing="0" cellpadding="0" lang="en">
    <tbody>
        <tr height="32" style="height:32px">
            <td></td>
        </tr>
        <tr align="center">
            <td>
                <div>
                    <div></div>
                </div>
                <table border="0" cellspacing="0" cellpadding="0" style="padding-bottom:20px;max-width:516px;min-width:220px">
                    <tbody>
                        <tr>
                            <td width="8" style="width:8px"></td>
                            <td>
                            <div style="x" align="center" class=""><img src="{{ $message->embed(public_path() . '/img/EZDEAL_LOGO_NEW.jpg') }}">
                                    <div style="font-family:'Google Sans',Roboto,RobotoDraft,Helvetica,Arial,sans-serif;border-bottom:thin solid #dadce0;color:rgba(0,0,0,0.87);line-height:32px;padding-bottom:24px;text-align:center;word-break:break-word">
                                        <div style="font-size:24px"></div>
                                        <table align="center" style="margin-top:8px">
                                            <tbody>
                                                <tr style="line-height:normal">
                                                    <td align="right" style="padding-right:8px"><img width="20" height="20" style="width:20px;height:20px;vertical-align:sub;border-radius:50%" src="" class="CToWUd"></td>
                                                </tr>
                                                <tr>
                                                    <div style="font-family:Roboto-Regular,Helvetica,Arial,sans-serif;font-size:14px;color:rgba(0,0,0,0.87);line-height:20px;padding-top:20px;text-align:left">Name: {!! $data['fullname'] !!}</div>
                                                </tr>
                                                <tr>
                                                    <td>Email Add: <a style="font-family:'Google Sans',Roboto,RobotoDraft,Helvetica,Arial,sans-serif;color:rgba(0,0,0,0.87);font-size:14px;line-height:20px">{!! $data['emailadd'] !!}</a></td>
                                                </tr>
                                                <tr>
                                                    <div style="font-family:Roboto-Regular,Helvetica,Arial,sans-serif;font-size:14px;color:rgba(0,0,0,0.87);line-height:20px;padding-top:20px;text-align:left">Contact: {!! $data['contactnum'] !!}</div>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    
                                    <div style="font-family:Roboto-Regular,Helvetica,Arial,sans-serif;font-size:14px;color:rgba(0,0,0,0.87);line-height:20px;padding-top:20px;text-align:left">Title: {!! $data['titlesubject'] !!}</div>
                                    <div style="font-family:Roboto-Regular,Helvetica,Arial,sans-serif;font-size:14px;color:rgba(0,0,0,0.87);line-height:20px;padding-top:20px;text-align:left">{!! $data['mymsg'] !!}</div>
                                </div>
                                <div style="text-align:left">
                                    <div style="font-family:Roboto-Regular,Helvetica,Arial,sans-serif;color:rgba(0,0,0,0.54);font-size:11px;line-height:18px;padding-top:12px;text-align:center">
                                    </div>
                                </div>
                            </td>  
                            <td width="8" style="width:8px"></td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
        <tr height="32" style="height:32px">
            <td></td>
        </tr>
    </tbody>
</table>