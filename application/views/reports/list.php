          <style>
              td{
                  font-size: 11px !important;
                  color: #000000 !important;
              }
              th{
                  font-size: 12px !important;
                  color: #000000 !important;
                  text-align:left !important;
border-top:1px solid #000000 !important;
border-bottom:1px solid #000000 !important;
height:30px !important;
              }
          </style>
          <!--<h3>Invoice Month : <?php echo $period; ?></h3>-->
          <table style="width: 100% !important;"><tr><td>Avser datum: <?php echo $period; ?></td><td style="text-align: right;"></td></tr></table>
          <center><h3 style="text-align: center;">Hyresgästlista</h3></center>
                        <table style="border-collapse:collapse;width: 100%">

                            <thead>
                           <tr>
                                <?php
                                foreach($headers as $key=>$val)
                                {
                                    if(in_array($key,array('5,7')))
                                    echo '<th style="text-align:right">'.$val.'&nbsp;&nbsp;&nbsp;&nbsp;</th>';
                                    else
                                        echo '<th>'.$val.'</th>';
                                }
                                ?>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $i=1;

                           // return array('S.No','Name','PIN','Park Type','Annaul Fee','Sum','From Date','To Date','Parking No','Address','Post Number','Post Ort');
                            $CI =& get_instance();
                            $bg_color=array('label-warning','label-success','label-danger','label-grey');
                            $sum=0;
                            foreach ($reports as $key=>$rows)
                            {
                                $park_type=$CI->Parkinginfo->parking_type();

                                $park_info=$this->Parkinginfo->get_info($rows['parking']);
                               //$park_date=$this->db->where(array('parking'=>$rows['parking'],'user'=>$rows['userid']))->get('parking_allocation')->row();

                               // $end_date=($park_date->to_date=='0000-00-00')?'':$park_date->to_date;
                                echo '<tr><td>'.$rows['contract_no'].'</td>
                                 <td>'.$rows['firstname']." ".$rows['lastname'].'</td>
                                <td>'.$rows['pin'].'</td>
                                <td>'.$park_type[$rows['parking_type']].'</td>
                                <td>  </td>
                                <td style="text-align:right;">'.$rows['amount'].'&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                <td>  </td>
                                <td style="text-align:right;">'.$rows['amount'].'&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                <td> </td>
                                <td> </td>
                                <td> </td>
                                <td style="text-align:left;">'.$rows['from_date'].'</td>
                                <td style="text-align:left;">'.$rows['to_date'].'</td>';
                                echo '</tr>';

                                echo '<tr><td></td>
                                 <td colspan="12">Objektsadress: '.$park_info->name.'</td></tr>';
                               echo '<tr><td></td><td colspan="12"> Aviadress: '.$rows['address'].' '.$rows['post_no']. '   '.$rows['post_ort'].'</td>';
                                $i++;
                                $sum=$sum+$rows['amount'];
                                echo '<tr><td colspan="13">&nbsp;</td></tr>';

                            }
                            echo '<tr><td style="border-top:1px solid #000000;" colspan="13"></td></tr>';

                            echo '<tr><th>Totalsumma</th><th colspan="4"></th><th style="text-align:right;">'.$sum.'&nbsp;&nbsp;&nbsp;&nbsp;</th><th></th><th style="text-align:right;">'.$sum.'&nbsp;&nbsp;&nbsp;&nbsp;</th><th colspan="5"></th></tr>';
                            ?>
                            </tbody>
                        </table>

                    </div>
                    <!-- /.box-body -->
                </div>