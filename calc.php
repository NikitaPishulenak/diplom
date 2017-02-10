<?php

session_start();
include 'config.php';
include 'core/db.php';
include 'core/core.php';
include 'core/ui.php';

?>
<html>
    <head>
        <title>Calc</title>
        <style>
            .calc_elem_t
            {
                width: 100%;
                line-height: 18px;
            }
            .calc_elem_b
            {
                width: 100%;
                line-height: 18px;
            }
        </style>
        <script>
            var x1=0;
            var x2=0;
            var x3=0;
            var x4=0;
            var x5=0;
            var x6=0;
            var x7=0;
            var x8=0;
            var x9=0;
            var x10=0;
            function js(id)
            {
                return document.getElementById(id);
            }
        function render()
        {
            js('v10').value=x10;
            js('v9').value=x9;
            js('v8').value=x8;
            js('v7').value=x7;
            js('v6').value=x6;
            js('v5').value=x5;
            js('v4').value=x4;
            js('v3').value=x3;
            js('v2').value=x2;
            js('v1').value=x1;
            rx();
        }
        function bc(x)
        {
            switch(x)
            {
                case 10:x10++;break;
                case 9:x9++;break;
                case 8:x8++;break;
                case 7:x7++;break;
                case 6:x6++;break;
                case 5:x5++;break;
                case 4:x4++;break;
                case 3:x3++;break;
                case 2:x2++;break;
                case 1:x1++;break;
                    
                    
            }
            render();
        }
        function cl()
        {
             x1=0;
             x2=0;
             x3=0;
             x4=0;
             x5=0;
             x6=0;
             x7=0;
             x8=0;
             x9=0;
             x10=0;
            render();
        }
        function rx()
        {
            var res=0;
            var cnt=0;
            var d10=0;
            var d50=0;
            var d50x=0;
            res = x10*10+x9*9+x8*8+x7*7+x6*6+x5*5+x4*4+x3*3+x2*2+x1*1;
            cnt = x10+x9+x8+x7+x6+x5+x4+x3+x2+x1;
            d10 = Math.round( res * 10 / cnt);
            d50 = Math.round( res * 10 / cnt);
            switch(d50)
            {
                case 30:d50x = 30;break;
                case 31:d50x = 34;break;
                case 32:d50x = 37;break;
                case 33:d50x = 40;break;
                case 34:d50x = 44;break;
                case 35:d50x = 48;break;
                case 36:d50x = 51;break;
                case 37:d50x = 55;break;
                case 38:d50x = 58;break;
                case 39:d50x = 62;break;
                case 40:d50x = 65;break;
                case 41:d50x = 69;break;
                case 42:d50x = 72;break;
                case 43:d50x = 76;break;
                case 44:d50x = 79;break;
                case 45:d50x = 83;break;
                case 46:d50x = 86;break;
                case 47:d50x = 90;break;
                case 48:d50x = 93;break;
                case 49:d50x = 97;break;
                case 50:d50x = 100;break;
                
            }
            js('d10').value=d10;
            js('d50').value=d50x;
            if(document.getElementsByName('cb')[0].checked)
                opener.document.getElementById('certificate_sum').value=d10;
            else
                opener.document.getElementById('certificate_sum').value=d50x;
        }
        
        
        
        //
        </script>
            
    </head>
    <body>
        <table width="100%">
            <tr>
                <td>
                    <input class="calc_elem_t"  id="v10" onchange="x10=parseInt(this.value);render();return true;" type="text" />
                </td>
                <td>
                    <input class="calc_elem_t"  id="v9" onchange="x9=parseInt(this.value);render();return true;" type="text" />
                </td>
                <td>
                    <input class="calc_elem_t"  id="v8" onchange="x8=parseInt(this.value);render();return true;" type="text" />
                </td>
                <td>
                    <input class="calc_elem_t"  id="v7" onchange="x7=parseInt(this.value);render();return true;" type="text" />
                </td>
                <td>
                    <input class="calc_elem_t"  id="v6" onchange="x6=parseInt(this.value);render();return true;" type="text" />
                </td>
            </tr>
            <tr>
                <td>
                    <input class="calc_elem_t"  id="v5" onchange="x5=parseInt(this.value);render();return true;" type="text" />
                </td>
                <td>
                    <input class="calc_elem_t"  id="v4" onchange="x4=parseInt(this.value);render();return true;" type="text" />
                </td>
                <td>
                    <input class="calc_elem_t"  id="v3" onchange="x3=parseInt(this.value);render();return true;" type="text" />
                </td>
                <td>
                    <input class="calc_elem_t"  id="v2" onchange="x2=parseInt(this.value);render();return true;" type="text" />
                </td>
                <td>
                    <input class="calc_elem_t"  id="v1" onchange="x1=parseInt(this.value);render();return true;" type="text" />
                </td>
            </tr>
            <tr>
                <td>
                    <input class="calc_elem_b"  id="b10" type="button" onclick="bc(10);"  value="10"/>
                </td>
                <td>
                    <input class="calc_elem_b"  id="b9" type="button" onclick="bc(9);" value="9"/>
                </td>
                <td>
                    <input class="calc_elem_b"  id="b8" type="button" onclick="bc(8);" value="8"/>
                </td>
                <td>
                    <input class="calc_elem_b"  id="b7" type="button" onclick="bc(7);" value="7"/>
                </td>
                <td>
                    <input class="calc_elem_b"  id="b6" type="button" onclick="bc(6);" value="6"/>
                </td>
            </tr>
            <tr>
                <td>
                    <input class="calc_elem_b"  id="b5" type="button" onclick="bc(5);" value="5"/>
                </td>
                <td>
                    <input class="calc_elem_b"  id="b4" type="button" onclick="bc(4);" value="4"/>
                </td>
                <td>
                    <input class="calc_elem_b"  id="b3" type="button" onclick="bc(3);" value="3"/>
                </td>
                <td>
                    <input class="calc_elem_b"  id="b2" type="button" onclick="bc(2);" value="2"/>
                </td>
                <td>
                    <input class="calc_elem_b"  id="b1" type="button" onclick="bc(1);" value="1"/>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <input type="radio" id="cb1" name="cb" value="1" checked=""/>
                    10á
                    :<input class="calc_elem_t"  id="d10" type="text" />
                </td>
                <td colspan="2">
                    <input type="radio" id="cb2" name="cb" value="2"/>
                    5á
                    :<input class="calc_elem_t"  id="d50" type="text" />
                </td>
                <td>
                    <input class="calc_elem_b"  id="b1" type="button" onclick="cl();" value="C"/>
                </td>
            </tr>
        </table>
    </body>
</html>