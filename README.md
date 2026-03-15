# 海外とVPNからのアクセス禁止にしたい！

って思ってる人結構いると思うんですよ(主観)。でもそこまでお金かけられない場合もあるじゃないですか。でもヤケクソになってイロイロやってたら完成してたのでここにage↑ておきます。

(For those living outside of Japan: This code is only valid within Japan. 🙏)



----



#### 1\.使い方


※haccessになってるけどファイル名の前にカンマ(.)付けてね
`.haccess`と`update_htaccess.php`をドキュメントルートにおいて、Cronで`update_htaccess.php`を15～45分おき位に叩く、それだけ。



#### 2\.システム要件

###### Apace **2.4**系が動いて尚且つ**権限がある**こと

2.2系とかは動きません。

(レンタルサーバーの人は注意したほうがいいかも。)



#### 3\.…どういうことだってばよ？

###### こうなってます

```apache

<RequireAny>

    #サーチBOT許可等

    <RequireAll>

    	#ベーシック認証つける用

    	<RequireAll>

    		<RequireAny>

    			#日本国内で使われるIPアドレスを許可

    		</RequireAny>

    		#日本国内にあるVPNのサーバーのIPアドレスを拒否

    	</RequireAll>

    </RequireAll>

</RequireAny>

```

日本国内で使われるIPアドレスにあたるマスク範囲をすべて記述した後、有名どころのVPNのIPアドレスのマスク範囲を虱潰しに拒否するというかなりﾊﾟﾜｰな方法をとってます。ただし、かなり頻繁にサーバーが変わって尚且つ公式からサーバーリストのAPIが出ているVpnGate(筑波大学のやつ)は`update_htaccess.php`を叩けば自動的に更新されるようになってます。



#### 4\.ブロックできるVPN一覧

* AirVPN
* Celo
* CyberGhost
* ExpressVPN
* FastestVPN
* GhostPath
* Giganews
* GooseVPN
* HideMe
* HotSpotSheild
* ibVPN
* IPVanish
* Ivacy
* iVPN
* MullVad
* NordVPN
* OpenGate
* OVPN
* PIA
* PrivateVPN
* ProtonVPN
* PureVPN
* SaferVPN
* SlickVPN
* SmartDNSProxy
* SurfShark
* TigerVPN
* TorGuard
* TotalVPN
* TrustZone
* TunnerBear
* VPN.ac
* VPN.ht
* VPNArea
* VPNTunnel
* VyprVPN
* VPNUnlimited
* Wistopia
* Windscribe
* ZoogVPN
* その他サーバーの所在地を日本に偽装するタイプのVPN



##### 5\.ご自身で編集される場合のガイド\&注意点

```apache

#そのほか例外的にアクセスを認める場合があればここに(GoogleBOTとか...)

#Require env ○○○

```

もしSEOの観点から**サーチBOTを許可したい**場合や、その他特別の事情があって**海外から一部のIPアドレスを許可したい**場合はこちらに書いてください。例では環境変数にマッチする時許可するようにしています。`Require ip 1.1.1.1`とかでも構いません。

```apace

#ベーシック認証をつける場合

#Require valid-user

```

もし**ベーシック認証等をつけたり、その他認証も必須にする場合**はこちらに書いてください。

```apace

<RequireAny>

    Require ip 1.0.16.0/20

    Require ip 1.0.64.0/18

    …

    Require ip 223.252.64.0/19

    Require ip 223.252.112.0/20

</RequireAny>

```

日本で使われているIPをまとめて書いたものです。こちらは[CGI's(cgis.biz)](https://www.cgis.biz/tools/access)様のツールを使用して改変したものになります。**感謝感謝**。VPNブロックいらないけど海外からはブロックしたいという場合はこれで十分だと思います。

```apace

#OpenGate

#!--ここから--

#!--ここまで--

```

**もし**`update_htaccess.php`**使う場合は消さないで！！**

Cron叩いてもVPNGateのIPアドレスがhtaccessに反映されなくなります

```apace

#AirVPN

Require not ip 146.70.76.0/24

Require not ip 193.148.16.0/24

Require not ip 45.87.213.0/24

…

Require not ip 194.180.179.0/24

Require not ip 194.233.100.0/24

Require not ip 94.177.17.0/24

```

26/3/14時点で私が確認できたVPNのIPアドレスのまとめ書きです。ここに書かれているものはすべて日本国内にサーバーがあるもののみです。これらはOpenGateとは違い`update_htaccess.php`ではアップデートされません。**新たにブロックする必要が出た場合は手動で追加する必要があります。**

他社のVPNであっても、同じマスク範囲でブロックできる場合は`#--ExampleVPN 0.0.0.0/0に同じ--`的なコメントを書いてます。

尚、一部VPNはCloudFlareやAmazonAWSをはじめとした大型プロバイダを使用している場合もあり、誤ブロックでサービスの動作に支障をきたす可能性があるものは`#※Cloudflare`のようなコメントを残しています。適宜コメントアウトしてください。



##### 7\.動作確認

私の方でProtonVPN,TunnerBear,Opengateの日本サーバーおよび海外サーバーからはアクセスできなくなっていることは確認しました。ほかは知らないですけど多分大丈夫です



##### 8\.最後に

使用は自己責任で

また、本プロジェクト達成にあたり以下を参考にしています。

[https://qiita.com/mf\_Mii/items/b0aec1215b7a694e856c#2-1-a-%E5%85%AC%E5%BC%8F%E3%81%AE%E3%83%AA%E3%82%B9%E3%83%88%E3%82%92%E6%8E%A2%E3%81%99](https://qiita.com/mf_Mii/items/b0aec1215b7a694e856c#2-1-a-%25E5%2585%25AC%25E5%25BC%258F%25E3%2581%25AE%25E3%2583%25AA%25E3%2582%25B9%25E3%2583%2588%25E3%2582%2592%25E6%258E%25A2%25E3%2581%2599)https://www.cgis.biz/tools/access

[https://github.com/haugene/vpn-configs-contrib](https://github.com/haugene/vpn-configs-contrib)

[https://github.com/Zomboided/service.vpn.manager.providers](https://github.com/Zomboided/service.vpn.manager.providers)

[https://tipstour.net/nordvpn-all-servers-in-japan](https://tipstour.net/nordvpn-all-servers-in-japan)

