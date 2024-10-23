<?php

$html = "<style>
            *{
                font-family: Arial;
                font-size: 10pt;
            }
        </style><div style='font-family: Arial;font-size: 10px;width:706px'>
            <table width='100%' border='0' align='center' cellpadding='0' cellspacing='0'>
                <tr>
                    <td width='100%'>
                        <table width='100%' border='0' cellpadding='0' cellspacing='0'>
                            <tr>
                                <td rowspan=6 width='100' align='center' valign='top'>
                                    <img src='" . base_url() . "images/logo.png' />
                                </td>
                                <td colspan='5'><b>PEMERINTAH DAERAH KHUSUS IBUKOTA JAKARTA</b></td>
                            </tr>
                            <tr>                            
                                <td width='150'><b>KOTA ADMINISTRASI</b></td>
                                <td colspan='2'>: <b>JAKARTA SELATAN</b></td>                            
                                <td>&nbsp;</td>
                                <td width='150'>&nbsp;</td>
                            </tr>
                            <tr>
                                <td><b>KECAMATAN</b></td>
                                <td colspan='2'>: <b>KEBAYORAN BARU</b></td>
                                <td>&nbsp;</td>
                                <td>Model : PM.I  WNI</td>
                            </tr>
                            <tr>
                                <td><b>KELURAHAN</b></td>
                                <td colspan='2'>: <b>GANDARIA UTARA</b></td>
                                <td>&nbsp;</td>
                                <td width='100'>Kode Kel : 4 7 0 9</td>

                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                            </tr>
                            <tr>
                                <td colspan=2 align='center'><b>Jalan</b> TAMAN RADIO DALAM VII</td>                            
                                <td width='100' align='center'>Tlp. 7208566</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td><hr style='color: #000;height: 2px;background: #000'/></td>
                </tr>
                <tr>
                    <td align='center'>
                        <b><u>SURAT  KETERANGAN</u></b><br/>
                        Nomor : " . $surat->nomor . "
                    </td>
                </tr>
                <tr>
                    <td align='center' width='100%'><br/>
                        <table width='90%' border='0' cellpadding='0' cellspacing='0'>
                            <tr>
                                <td colspan=3>
                                    Yang bertanda tangan di bawah ini Kepala Kelurahan Gandaria Utara, Kecamatan Kebayoran Baru
                                    menerangkan bahwa<br/><br/> 
                                </td>
                            </tr>
                            <tr height='21'>
                                <td width='29%' style='padding-left: 5px;'>N a m a</td>
                                <td width='1%'>:</td>
                                <td width='70%'><b>" . $surat->nama . "</b></td>
                            </tr>
                            <tr height='21'>
                                <td style='padding-left: 5px;'>Tempat / Tanggal lahir</td>
                                <td>:</td>
                                <td>" . $surat->tempat_lahir . ", " . $this->model_surat->my_date($surat->tanggal_lahir) . "</td>
                            </tr>
                            <tr height='21'>
                                <td style='padding-left: 5px;'>Jenis Kelamin</td>
                                <td>:</td>
                                <td>" . $surat->jenis_kelamin . "</td>
                            </tr>
                            <tr height='21'>
                                <td style='padding-left: 5px;'>Agama</td>
                                <td>:</td>
                                <td>" . $surat->agama . "</td>
                            </tr>
                            <tr height='21'>
                                <td style='padding-left: 5px;'>Kewarganegaraan</td>
                                <td>:</td>
                                <td>" . $surat->kewarganegaraan . "</td>
                            </tr>
                            <tr height='21'>
                                <td style='padding-left: 5px;'>No. KTP / SKTLD</td>
                                <td>:</td>
                                <td>" . $surat->no_identitas . "</td>
                            </tr>                        
                            <tr height='21'>
                                <td style=padding-left: 5px;>Alamat</td>
                                <td>:</td>
                                <td rowspan='2'>" . nl2br($surat->alamat) . "</td>
                            </tr>
                            <tr height='21'>
                                <td style='padding-left: 5px;'>&nbsp;</td>
                                <td></td>
                            </tr>
                            <tr height='21'>
                                <td style='padding-left: 5px;'>Pekerjaan</td>
                                <td>:</td>
                                <td>" . $surat->pekerjaan . "</td>
                            </tr>
                            <tr valign='top' height='21'>
                                <td style='padding-left: 5px;'>Maksud / Keperluan</td>
                                <td>:</td>
                                <td>" . nl2br($surat->keperluan) . "</td>
                            </tr>
                            <tr>
                                <td colspan='3' style='padding-top: 20px;'>Demikian surat keterangan ini dibuat untuk dapat dipergunakan sebagaimana mestinya</td>
                            </tr>
                        </table> 
                    </td>
                </tr>
                <tr>
                    <td align='center'><br/>
                        <table width='90%' border='0' cellpadding='0' cellspacing='0'>
                            <tr>
                                <td width='33%'>&nbsp;</td>
                                <td width='33%'>&nbsp;</td>
                                <td width='34%' style='padding-bottom: 4px;'>Jakarta, " . $this->model_surat->my_date($surat->tanggal) . "</td>
                            </tr>
                            <tr valign='top'>
                                <td width='33%' align='center'>
                                    Tanda Tangan Ybs
                                    <br/>
                                    <br/>
                                    <br/>
                                    <br/>
                            <u><b>" . $surat->nama . "</b></u>
                    </td>
                    <td width='33%'>&nbsp;</td>
                    <td width='34%' align='center'>
                        Lurah Gandaria Utara
                        <br/>
                        <br/>
                        <br/>
                        <br/>
                        <hr style='color: #000;height: 1px;background: #000'/>
                        <span style='float: left'>NIP.</span>
                    </td>
                </tr>
                <tr>
                    <td width='33%'>&nbsp;</td>
                    <td width='33%'>&nbsp;&nbsp;Nomor :</td>
                    <td width='34%'>&nbsp;</td>
                </tr>
                <tr>
                    <td width='33%'>&nbsp;</td>
                    <td width='33%'>&nbsp;&nbsp;Tanggal :</td>
                    <td width='34%'>&nbsp;</td>
                </tr>
                <tr>
                    <td colspan='3'>&nbsp;</td>
                </tr>
                <tr>
                    <td width='33%'>&nbsp;</td>
                    <td width='33%' align='center'>
                        Mengetahui
                        <br/>
                        <br/>
                        <br/>
                        <br/>
                        <hr style='color: #000;height: 1px;background: #000'/>
                        <span style='float: left'>NIP.</span>
                    </td>
                    <td width='34%'>&nbsp;</td>
                </tr>
            </table>
        </td>
        </tr>
        </table>
        </div>";
echo $html;
