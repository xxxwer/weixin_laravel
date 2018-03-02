<xml>
    <ToUserName><![CDATA[{{ $message->FromUserName }}]]></ToUserName>
    <FromUserName><![CDATA[{{ $message->ToUserName }}]]></FromUserName>
    <CreateTime>{{ time() }}</CreateTime>
    <MsgType><![CDATA[news]]></MsgType>
    <ArticleCount>{{ count($articles) }}</ArticleCount>
    <Articles>
        @foreach($articles as $a)
        <item>
            <Title><![CDATA[{!! $a['title'] !!}]]></Title>
            <Description><![CDATA[{!! $a['description'] !!}]]></Description>
            <PicUrl><![CDATA[{!! $a['imageUrl'] !!}]]></PicUrl>
            <Url><![CDATA[{!! $a['url'] !!}]]></Url>
        </item>
        @endforeach
    </Articles>
</xml>