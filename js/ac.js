/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */



$(document).ready(function(){
    var arrNames= new Array("���������","����������","�������","�����","�����","�����","����","���","�����","�����","����","���������","��������","��������","������","��������","��� ","�����","����","�����","��������","�������","�������","�����","���� ","�����","������","�����","��������","��������� ","�������","�������","�������","��������","���� ","��������","������","��������","�������� ","����","�������","�������","�����","��������","���������","��������","������ ","��������","�������","����","�������","��������","������","�����","�����","�����","����","�������","�������","�������","����","���������","�����","���������","����","�����","�����","����","����","������","����","����� ","������","��������","����","������","�������","����������","��������","������","������","������","������","��������","�����","�����","�����","������","�������","����","������","���������","������","�����","����","��������","������","������","�������","����� ","�������","�������","����","������","�������","��������","������","����","������","����","�����","�����","�����","�������","������","�������","������","������","����","�����","������","������","������","��������","���������","����","������","��������","���������","������","������","�������","������","�������","�����","������","Ը���","������","������","��������","����","������","��������","����","����","�����","����","��","��� ","�����","����","��������");
    var arrMides= new Array("����������","�����������","�������������","�������������","����������","����������","�����������","�����������","�����������","����������","���������","�����������","�����������","���������","���������","���������","����������","���������","���������","���������","�����������","���������","���������","���������","������������","������������","����������","����������","��������","����������","����������","����������","�����������","����������","����������","�������������","����������","����������","�����������","������������","������������","�������������","������������","������������","�����������","�����������","�����������","����������","����������","�����������","�����������","����������","����������","����������","����������","����������","��������","��������","��������","��������","����������","���������","���������","���������","����������","��������������","��������������","����������","����������","��������","����������","�������","����������","�����������","����������","����������","��������","����������","���������","������������","����������","����������","����������","����������","��������","��������","��������","��������","��������","��������","������������","���������","���������","����������","���������","�������������","����������","����������","�������������","�������������","��������","���������","���������","��������","�������������","�������������","����������","����������","����������","����������","��������","���������","���������","Ը�������","���������","����������","����������","����������","�������","�������","������","�����������");
    
    $('#name').autocomplete(
        arrNames
        );
   $('#midname').autocomplete(
   arrMides
    );
    
    $('#f_name').autocomplete(
        arrNames
        );
   $('#f_midname').autocomplete(
   arrMides
    );
   $('#m_name').autocomplete(
        arrNames
        );
   $('#m_midname').autocomplete(
   arrMides
    );
            
   $('#uzo_data').autocomplete(
   ['��� ���������� ������������',
'��� ���������� ������������',
'��� ����������� ������������',
'��� ������������ ������������',
'��� �������� ������������',
'��� ����������� ������������',
'����� "������� ��������"',
'��������� ����� "��������"',
'��������� ����� "��������"',
'���������� ����� "��������"',
'����������� ����� "��������"',
'���������� ����� "��������"']
);
        
});