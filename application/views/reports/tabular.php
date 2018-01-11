          <style>
              td{
                  font-size: 11px !important;
                  color: #000000 !important;
              }
              th{
                  font-size: 12px !important;
                  color: #000000 !important;
              }
          </style>
          <!--<h3>Invoice Month : <?php echo $period; ?></h3>-->
          <table style="width: 100% !important;"><tr><td>Avser datum: <?php echo $period; ?></td><td style="text-align: right;">Utskriven av Ewa Hopstadius (attestant)</td></tr></table>
          <center><h3 style="text-align: center;">Hyresgästlista</h3></center>
                        <table style="border: 1px solid #000000; border-collapse:collapse;width: 100%">

                            <thead>
                           <tr style="border: 1px solid #000000;"><th>Kontraktsnr</th><th>Hyresgäst</th><th>Pnr/Orgnr </th><th>Objektstyp</th><th></th><th>Årshyra</th>

                               <th>Tillägg </th><th>Summa </th><th></th><th> </th><th></th> <th>Upps.datum</th><th>Slutdatum</th>
                           </tr>
                            <tr>
                                <?php
                                foreach($headers as $key=>$val)
                                {
                                    //echo '<th>'.$val.'</th>';
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
                               //$park_date=$this->db->where(array('parking'=>$rows['parking'],'user'=>$rows['userid']))->get('parking_allocation')->row();

                               // $end_date=($park_date->to_date=='0000-00-00')?'':$park_date->to_date;
                                echo '<tr><td> </td>
                                 <td>'.$rows['firstname']." ".$rows['lastname'].'</td>
                                <td>'.$rows['pin'].'</td>
                                <td>'.$park_type[$rows['parking_type']].'</td>
                                <td>  </td>
                                <td style="text-align:right;">'.$rows['amount'].'</td>
                                <td>  </td>
                                <td style="text-align:right;">'.$rows['amount'].'</td>
                                <td> </td>
                                <td> </td>
                                <td> </td>
                                <td style="text-align:center;">'.$rows['from_date'].'</td>
                                <td style="text-align:center;">'.$rows['to_date'].'</td>';
                                echo '</tr>';

                                echo '<tr><td></td>
                                 <td colspan="12">Objektsadress: '.$rows['apartment'].'</td></tr>';
                               echo '<tr><td></td><td colspan="12"> Aviadress: '.$rows['address'].' '.$rows['post_no']. '   '.$rows['post_ort'].'</td>';
                                $i++;
                                $sum=$sum+$rows['amount'];
                            }
                            echo '<tr><td style="border-top:1px solid #000000;" colspan="13"></td></tr>';

                            echo '<tr><td>Totalsumma</td><td colspan="4"></td><td style="text-align:right;">'.$sum.'</td><td></td><td style="text-align:right;">'.$sum.'</td><td colspan="5"></td>'
                            ?>
                            </tbody>
                        </table>

                    </div>
                    <!-- /.box-body -->
                </div>