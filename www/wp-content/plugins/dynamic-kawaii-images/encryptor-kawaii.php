<?php
// By Andrew Salko, based on article: 
// http://vladimirkim.livejournal.com/674.html

class EncryptorKawaii
{
	var $Password='AndrewSalkoKawaiiMobile';
	
	//������� ��� ����������
	//
	public function Encode($text)
	{				
		$pswLen=strlen($this->Password);
		$j=0;

		$resultText='';
		for($i=0;$i<strlen($text);$i++)
		{
			$charCode=ord($text[$i]);
			$passwCode=ord($this->Password[$j]);			

			$j++;
			if($j==strlen($pswLen))
			{
				$j=0;
			}

			$encByte=$charCode ^ $passwCode;
			$hexStr=dechex($encByte);
			if(strlen($hexStr)==1)
			{
				$hexStr='0' . $hexStr; //����� ���� � ����� 0A
			}

         	$resultText .= $hexStr;
		}
		return $resultText;
	}//Encode


	//������� ��� ������������
	//(������ ����������� � ���� ����.������ ����, �� ��������� � ����������)
	public function Decode($text)
	{		
		$pswLen=strlen($this->Password);
		$j=0;

		$resultText='';
		for($i=0;$i<strlen($text);$i+=2)
		{
			//����������� 2 ������� � ���� (�� hex)
			$charCode=hexdec(substr($text, $i, 2));
			$passwCode=ord($this->Password[$j]);			

			$j++;
			if($j==strlen($pswLen))
			{
				$j=0;
			}

			$encByte=$charCode ^ $passwCode;
         	$resultText .= chr($encByte);
		}
		return $resultText;
	}//Decode

}

