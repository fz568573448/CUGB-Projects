var width=window.innerWidth;
var height=window.innerHeight;
document.write('<style type="text/css">table {height:'+(height-25)+'px; width:'+Math.min(width,800)+'px;}</style>');
var weekends1=0,weekends2=0,evening=0;
if (getCookie("weekends1")=="1") weekends1=1;
if (getCookie("weekends2")=="1") weekends2=1;
if (getCookie("evening")=="1") evening=1;

//处理td大小
var myh,myw;
if (weekends1==0&&weekends2==0) myw=20;
else if (weekends2==0) myw=16;
else myw=14;
if (evening==0) myh=25;
else myh=20;
document.write('<style type="text/css">td{height:'+myh+'%;width:'+myw+'%;}</style>');

document.write('<table>');
for (var i=1;i<=5;i++)
{
    if (i==5&&evening==0) continue;
    document.write('<tr>');
    for (var j=1;j<=7;j++)
    {
        if ((j==6||j==7)&&weekends1==0&&weekends2==0) continue;
        if ((j==7)&&weekends2==0) continue;
        document.write('<td id='+j+'-'+i+'>&nbsp;</td>');
    }
    document.write('</tr>');
}
document.write('</table>');

//初始化正则
var regstr="\\."+week+"\\.";
var reg=new RegExp(regstr);

//处理table
var num=getCookie("num");
var colidx=0;
for (var i=0;i<num;i++)
{
    //document.write(getCookie(i.toString())+"<br />");
    var s=Base64.decode(getCookie("course"+i.toString()));
    //document.write(s+"<br />");
    var a=s.split("|");
    var flag=0;
    for (var j=0;j<a[2];j++)
    {
        //document.write("<p>=======</p>");
        var b=a[3+j].split("=");
        //document.write(b[0]);
        //document.write(regstr+"<br />");
        //if (reg.test(b[0])) document.write(b[1]+b[2]+b[3]+"<br />");
        if (reg.test(b[0]))
        {
            flag=1;
            for (var k=1;k<=5;k++)
            {
                var regstr2="\\."+k+"\\.";
                var reg2=new RegExp(regstr2);
                var id=b[1]+"-"+k;
                if (reg2.test(b[2]))
                {
                    var ele=document.getElementById(id);
                    var oldhtml=ele.innerHTML;
                    var html='<strong>'+a[0]+'</strong>'+"<br />"+a[1]+"<br />"+'<strong>'+b[3]+'</strong>';
                    var oldcol=ele.className;
                    var col="col"+colidx;
                    if (oldhtml=="&nbsp;")
                    {
                        ele.innerHTML=html;
                        ele.className=col;
                    }
                    else
                    {
                        ele.className="";
                        ele.innerHTML='<div class="'+oldcol+'" style="height:50%;">'+oldhtml+'</div>'+
                                      '<div class="'+col+'" style="height:50%;">'+html+'</div>';
                    }
                }
            }
        }
    }
    colidx+=flag;
}

/*

矿产勘查学|曹毅、王功文、陈永清|16|.1..2..3..4..5.=5=.3.=综合楼504|.7.=1=.2.=实验室科-909|.8..9..10..11.=3=.1.=综合楼504|.12..13..14.=5=.3.=实验室科-909|.4..5.=1=.2.=实验室科-909|.3..4..5.=3=.1.=综合楼504|.8.=5=.3.=综合楼504|.6.=5=.3.=实验室科-909|.12..13..14.=3=.1.=实验室科-909|.8..9..10..11..12.=1=.2.=综合楼601|.1.=3=.1.=综合楼504|.13..14..15.=1=.2.=实验室科-909|.1..2..3.=1=.2.=综合楼601|.6..7.=3=.1.=实验室科-909|.10..11.=5=.3.=综合楼504|.2.=3=.1.=实验室科-909

*/