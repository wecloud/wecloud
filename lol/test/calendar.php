<?php
   echo " ��� ��������� ";
   echo "<br>";
  //  <br>;
  // echo "<td>"����"</td>";
  echo "<table border=1>";
   echo " ����������� ������� ����� ������� ������� ������� �����������";
   echo "</table>";
  // ��������� ����� ���� � ������� ������
  $dayofmonth = date('t');
  // ������� ��� ���� ������
  $day_count = 1;

  // 1. ������ ������
  $num = 0;
  for($i = 0; $i < 7; $i++)
  {
    // ��������� ����� ��� ������ ��� �����
    $dayofweek = date('w',
                      mktime(0, 0, 0, date('m'), $day_count, date('Y')));
    // �������� � ����� � ������� 1 - �����������, ..., 6 - �������
    $dayofweek =  $dayofweek - 1;
    if($dayofweek == -1) $dayofweek = 6;

    if($dayofweek == $i)
    {
      // ���� ��� ������ ���������,
      // ��������� ������ $week
      // ������� ������
      $week[$num][$i] = $day_count;
      $day_count++;
    }
    else
    {
      $week[$num][$i] = "";
    }
  }

  // 2. ����������� ������ ������
  while(true)
  {
    $num++;
    for($i = 0; $i < 7; $i++)
    {
      $week[$num][$i] = $day_count;
      $day_count++;
      // ���� �������� ����� ������ - �������
      // �� �����
      if($day_count > $dayofmonth) break;
    }
    // ���� �������� ����� ������ - �������
    // �� �����
    if($day_count > $dayofmonth) break;
  }

    // 3. ������� ���������� ������� $week
  // � ���� ���������
  // ������� �������
  echo "<table border=1>";
  for($i = 0; $i < count($week); $i++)
  {
    echo "<tr>";
    for($j = 0; $j < 7; $j++)
    {
      if(!empty($week[$i][$j]))
      {
        // ���� ����� ���� � �������� � �����������
        // ������������ ��
        if($j == 5 || $j == 6) 
             echo "<td><font color=red>".$week[$i][$j]."</font></td>";
        else echo "<td>".$week[$i][$j]."</td>";
      }
      else echo "<td>&nbsp;</td>";
    }
    echo "</tr>";
  } 
  echo "</table>";

?>