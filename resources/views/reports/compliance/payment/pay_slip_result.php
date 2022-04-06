<?php if ($employee_info):?>
    <div class="container">
        <?php foreach ($employee_info as $key => $row):
            $absent_day = $row['AbsentDay'];
            $DaysInMonth = date_conversion('d',$row['ToDate']);

            $leave_type = explode(',',$row['LeaveType']);
            $leave_days = explode(',',$row['LeaveDays']);
            $leave_data = array_combine($leave_type,$leave_days);

            $cl = $leave_data['CL'] ?? 0;
            $sl = $leave_data['SL'] ?? 0;
            $el = $leave_data['EL'] ?? 0;
            $spl = $leave_data['SPL'] ?? 0;
            $total_leave = $cl + $sl + $el + $spl;
            $present_day = $DaysInMonth - $total_leave - $absent_day;
            $payable_day  = $DaysInMonth - $absent_day;

            $OTAmount = $row['OT'];
            $OTHour = $row['OTHour'];
            $OTRate = number_round($row['OTRate'], 2);

            $gross = number_round($row['orgGROSS']);
            $conveyance = number_round($row['orgCONVEYANCE']) + number_round($row['orgMEDICAL']);
            $attendanceBonus = number_round($row['ATTENDANCEBONUS']);
            $stamp =  $row['STAMP'];
            $absenteeism = $row['Absenteeism'];
            $pf = $row['PF'];
            $advance = $row['ADVANCE'];
            $deduction = $absenteeism+$pf+$advance ;
            $payable = ($gross-$deduction)+$attendanceBonus;//+$conveyance
            $totalPayable = $payable+$OTAmount-$stamp;
        ?>
            <div class="row mt-1 mb-2">
                <div class="col-sm-6">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="float-right">
                                <p>
                                    <strong><?php echo $company_info->name;?></strong>
                                    <br/><?php echo $company_info->address;?>
                                    <br/>Reg. No.: ১৯৪১৯/নাঃগঞ্জ
                                    <br/>বেতন রশিদ-Pay Slip
                                </p>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <span class="float-right">Office Copy</span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <table class="table table-borderless table-sm table-responsive-x">
                                <tbody>
                                    <tr>
                                        <td>মাস</td>
                                        <td>: <?php echo $Month;?></td>
                                        <td class="float-right">সন</td>
                                        <td class="w-25">: <?php echo translate_number($Year,'bn');?></td>
                                    </tr>
                                    <tr>
                                        <td>কার্ড নং</td>
                                        <td>: <?php echo $row['EmployeeCode']; ?></td>
                                        <td class="float-right">পদবী</td>
                                        <td>: <?php echo $row['Designation']; ?></td>
                                    </tr>
                                    <tr>
                                        <td>নাম</td>
                                        <td>: <?php echo $row['EmployeeName']; ?></td>
                                        <td class="float-right">সেকশন</td>
                                        <td>: <?php echo $row['Section']; ?></td>
                                    </tr>
                                    <tr>
                                        <td>গ্রেড</td>
                                        <td>:</td>
                                        <td>যোগদানের তারিখ</td>
                                        <td>: <?php echo translate_number(date_conversion('d-j-Y',$row['DOJ']),'bn') ?? ''; ?></td>
                                    </tr>
                                </tbody>
                            </table>
                            <table class="table table-bordered table-sm table-responsive-x">
                                <tbody>
                                    <tr>
                                        <td>নির্ধারিত মোট কার্য দিবস</td>
                                        <td>:00</td>
                                        <td>হাজিরা দিবস</td>
                                        <td>:00</td>
                                        <td>মজুরিযোগ্য দিন</td>
                                        <td>: <?php echo translate_number($payable_day, 'bn');?></td>
                                    </tr>
                                    <tr>
                                        <td>অনুপস্থিত দিন</td>
                                        <td>: <?php echo translate_number($absent_day,'bn');?></td>
                                        <td>অসুস্থতা  জনিত ছুটি </td>
                                        <td>: <?php echo translate_number($sl,'bn');?></td>
                                        <td>সাপ্তাহিক ছুটি </td>
                                        <td>: <?php echo translate_number($row['WeeklyOffDay'],'bn');?></td>
                                    </tr>
                                    <tr>
                                        <td>নৈমত্তিক ছুটি</td>
                                        <td>: <?php echo translate_number($cl,'bn');?></td>
                                        <td>অন্যান্য ছুটি</td>
                                        <td>:00</td>
                                        <td>মাসের মোট দিন</td>
                                        <td>: <?php echo translate_number($DaysInMonth,'bn') ?? ''; ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-sm-12">
                            <div class="row">
                                <div class="col-sm-6">
                                    <table class="table table-bordered table-sm table-responsive-x">
                                        <tbody>
                                            <tr>
                                                <td>প্রাপ্য মুজুরি</td>
                                                <td>টাকা</td>
                                            </tr>
                                            <tr>
                                                <td>নির্ধারিত মোট মজুরী</td>
                                                <td>: <?php echo translate_number($gross, 'bn');?></td>
                                            </tr>
                                            <tr>
                                                <td>মুল মজুরী</td>
                                                <td>: <?php echo  translate_number(number_round($row['orgBASIC']), 'bn');?></td>
                                            </tr>
                                            <tr>
                                                <td>যাতায়াত ভাতা</td>
                                                <td>: <?php echo translate_number($conveyance,'bn');?></td>
                                            </tr>
                                            <tr>
                                                <td>বাড়ি ভাড়া ভাতা</td>
                                                <td>: <?php echo translate_number(number_round($row['orgHOUSERENT']), 'bn');?></td>
                                            </tr>
                                            <tr>
                                                <td>চিকিৎসা ভাতা</td>
                                                <td>: <?php echo translate_number(number_round($row['orgMEDICAL']),'bn');?></td>
                                            </tr>
                                            <tr>
                                                <td>হাজিরা বোনাস</td>
                                                <td>: <?php echo translate_number(number_round($row['ATTENDANCEBONUS']), 'bn');?></td>
                                            </tr>
                                            <tr>
                                                <td>অতিরিক্ত শ্রমের ঘণ্টা</td>
                                                <td>: <?php echo translate_number($OTHour, 'bn');?></td>
                                            </tr>
                                            <tr>
                                                <td>প্রতি ঘণ্টা ও.টি. হার</td>
                                                <td>: <?php echo translate_number($OTRate, 'bn');?></td>
                                            </tr>
                                            <tr>
                                                <td>অতিরিক্ত শ্রমের মজুরী</td>
                                                <td>: <?php echo translate_number($OTAmount, 'bn');?></td>
                                            </tr>
                                            <tr>
                                                <td>মোট টাকা</td>
                                                <td>: <?php echo translate_number($payable, 'bn');?></td>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>মোট প্রদেয় টাকা</td>
                                                <td>: <?php echo translate_number($totalPayable, 'bn');?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-sm-6">
                                    <table class="table table-bordered table-sm table-responsive-x">
                                        <tbody>
                                            <tr>
                                                <td>কর্তন মজুরী</td>
                                                <td>টাকা</td>
                                            </tr>
                                            <tr>
                                                <td>আয়কর</td>
                                                <td>: 00</td>
                                            </tr>
                                            <tr>
                                                <td>পি.এফ.</td>
                                                <td>: <?php echo translate_number($pf, 'bn'); ?></td>
                                            </tr>
                                            <tr>
                                                <td>অনুপস্থিতি বাবদ</td>
                                                <td>: <?php echo translate_number(number_round($absenteeism),'bn'); ?></td>
                                            </tr>
                                            <tr>
                                                <td>অগ্রিম মজুরী বাবদ</td>
                                                <td>: <?php echo translate_number($advance, 'bn');?></td>
                                            </tr>
                                            <tr>
                                                <td>রেভিনিউ স্ট্যাম্প বাবদ</td>
                                                <td>: <?php echo translate_number($stamp,'bn');?></td>
                                            </tr>
                                            <tr>
                                                <td>মোট টাকা</td>
                                                <td>: <?php echo translate_number($deduction, 'bn'); ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <p>রশিদ বুঝিয়া পাইলাম</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="float-right">
                                <p>
                                    <strong><?php echo $company_info->name;?></strong>
                                    <br/><?php echo $company_info->address;?>
                                    <br/>Reg. No.: ১৯৪১৯/নাঃগঞ্জ
                                    <br/>বেতন রশিদ-Pay Slip
                                </p>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <span class="float-right">Employee Copy</span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <table class="table table-borderless table-sm table-responsive-x">
                                <tbody>
                                    <tr>
                                        <td>মাস</td>
                                        <td>: <?php echo $Month;?></td>
                                        <td class="float-right">সন</td>
                                        <td class="w-25">: <?php echo translate_number($Year,'bn');?></td>
                                    </tr>
                                    <tr>
                                        <td>কার্ড নং</td>
                                        <td>: <?php echo $row['EmployeeCode']; ?></td>
                                        <td class="float-right">পদবী</td>
                                        <td>: <?php echo $row['Designation']; ?></td>
                                    </tr>
                                    <tr>
                                        <td>নাম</td>
                                        <td>: <?php echo $row['EmployeeName']; ?></td>
                                        <td class="float-right">সেকশন</td>
                                        <td>: <?php echo $row['Section']; ?></td>
                                    </tr>
                                    <tr>
                                        <td>গ্রেড</td>
                                        <td>:</td>
                                        <td>যোগদানের তারিখ</td>
                                        <td>: <?php echo translate_number(date_conversion('d-j-Y',$row['DOJ']),'bn') ?? ''; ?></td>
                                    </tr>
                                </tbody>
                            </table>
                            <table class="table table-bordered table-sm table-responsive-x">
                                <tbody>
                                <tr>
                                    <td>নির্ধারিত মোট কার্য দিবস</td>
                                    <td>:00</td>
                                    <td>হাজিরা দিবস</td>
                                    <td>:00</td>
                                    <td>মজুরিযোগ্য দিন</td>
                                    <td>: <?php echo translate_number($payable_day, 'bn');?></td>
                                </tr>
                                <tr>
                                    <td>অনুপস্থিত দিন</td>
                                    <td>: <?php echo translate_number($absent_day,'bn');?></td>
                                    <td>অসুস্থতা  জনিত ছুটি </td>
                                    <td>: <?php echo translate_number($sl,'bn');?></td>
                                    <td>সাপ্তাহিক ছুটি </td>
                                    <td>: <?php echo translate_number($row['WeeklyOffDay'],'bn');?></td>
                                </tr>
                                <tr>
                                    <td>নৈমত্তিক ছুটি</td>
                                    <td>: <?php echo translate_number($cl,'bn');?></td>
                                    <td>অন্যান্য ছুটি</td>
                                    <td>:00</td>
                                    <td>মাসের মোট দিন</td>
                                    <td>: <?php echo translate_number($DaysInMonth,'bn') ?? ''; ?></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-sm-12">
                            <div class="row">
                                <div class="col-sm-6">
                                    <table class="table table-bordered table-sm table-responsive-x">
                                        <tbody>
                                        <tr>
                                            <td>প্রাপ্য মুজুরি</td>
                                            <td>টাকা</td>
                                        </tr>
                                        <tr>
                                            <td>নির্ধারিত মোট মজুরী</td>
                                            <td>: <?php echo translate_number($gross, 'bn');?></td>
                                        </tr>
                                        <tr>
                                            <td>মুল মজুরী</td>
                                            <td>: <?php echo  translate_number(number_round($row['orgBASIC']), 'bn');?></td>
                                        </tr>
                                        <tr>
                                            <td>যাতায়াত ভাতা</td>
                                            <td>: <?php echo translate_number($conveyance,'bn');?></td>
                                        </tr>
                                        <tr>
                                            <td>বাড়ি ভাড়া ভাতা</td>
                                            <td>: <?php echo translate_number(number_round($row['orgHOUSERENT']), 'bn');?></td>
                                        </tr>
                                        <tr>
                                            <td>চিকিৎসা ভাতা</td>
                                            <td>: <?php echo translate_number(number_round($row['orgMEDICAL']),'bn');?></td>
                                        </tr>
                                        <tr>
                                            <td>হাজিরা বোনাস</td>
                                            <td>: <?php echo translate_number(number_round($row['ATTENDANCEBONUS']), 'bn');?></td>
                                        </tr>
                                        <tr>
                                            <td>অতিরিক্ত শ্রমের ঘণ্টা</td>
                                            <td>: <?php echo translate_number($OTHour, 'bn');?></td>
                                        </tr>
                                        <tr>
                                            <td>প্রতি ঘণ্টা ও.টি. হার</td>
                                            <td>: <?php echo translate_number($OTRate, 'bn');?></td>
                                        </tr>
                                        <tr>
                                            <td>অতিরিক্ত শ্রমের মজুরী</td>
                                            <td>: <?php echo translate_number($OTAmount, 'bn');?></td>
                                        </tr>
                                        <tr>
                                            <td>মোট টাকা</td>
                                            <td>: <?php echo translate_number($payable, 'bn');?></td>
                                        </tr>
                                        <tr>
                                            <td>মোট প্রদেয় টাকা</td>
                                            <td>: <?php echo translate_number($totalPayable, 'bn');?></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-sm-6">
                                    <table class="table table-bordered table-sm table-responsive-x">
                                        <tbody>
                                        <tr>
                                            <td>কর্তন মজুরী</td>
                                            <td>টাকা</td>
                                        </tr>
                                        <tr>
                                            <td>আয়কর</td>
                                            <td>: 00</td>
                                        </tr>
                                        <tr>
                                            <td>পি.এফ.</td>
                                            <td>: <?php echo translate_number($pf, 'bn'); ?></td>
                                        </tr>
                                        <tr>
                                            <td>অনুপস্থিতি বাবদ</td>
                                            <td>: <?php echo translate_number(number_round($absenteeism),'bn'); ?></td>
                                        </tr>
                                        <tr>
                                            <td>অগ্রিম মজুরী বাবদ</td>
                                            <td>: <?php echo translate_number($advance, 'bn');?></td>
                                        </tr>
                                        <tr>
                                            <td>রেভিনিউ স্ট্যাম্প বাবদ</td>
                                            <td>: <?php echo translate_number($stamp,'bn');?></td>
                                        </tr>
                                        <tr>
                                            <td>মোট টাকা</td>
                                            <td>: <?php echo translate_number($deduction, 'bn'); ?></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <p>রশিদ বুঝিয়া পাইলাম</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach;?>
    </div>
<?php else:
    echo "<h5 class='text text-danger'>There is no data according to your search.</h5>";
endif;
?>