<?php
namespace App\Repo\Common;

class ReturnF
{
    public static function returnTextXML($content, $xmlData)
    {
        $xmlData->MsgType = 'text';
        $xmlData->Content = $content . "\n" . '<a href="http://www.bing.com">使用bing搜索 测试链接</a>';
        return view('index/index/returnTextXML', ['message' => $xmlData]);
    }

    public static function returnNewsXML($articles, $xmlData)
    {
        $xmlData->MsgType = 'text';
        return view('index/index/returnNewsXML', ['message' => $xmlData, 'articles' => $articles]);
    }

    // 图文消息测试1
    public static function imgInfo1($param, $xmlData)
    {
        try {
            $articles[0]['title'] = '导论：人性皆有裂隙，那是我们共同的隐秘';
            $articles[0]['description'] =
                '人性皆有裂隙，而那也是光照进来的地方。倘若不是如此，心理学便不会在百余年中用好奇而温柔的目光凝视着矛盾、复杂的我们，揣摩我们为应对生活中的种种情境，发展出的自己的行为模式。' . "\n" .
                '这些惯常的、适应性的行为模式被定义为人格。它是我们人性的裂隙，独特的纹理揭示着我们的隐秘，隐秘中有冲突与矛盾，记忆和过往，有我们成长的生命力和最渴望回避的痛苦。一旦我们决定去了解它们，我们就有了认识彼此、消除隔阂的那一束光。';
            $articles[0]['imageUrl'] = 'https://img1.doubanio.com/dae/niffler/niffler/images/7be0effe-3f69-11e7-8261-0242ac11001b.png';
            $articles[0]['url'] = 'https://m.douban.com/time/column/43?dt_time_source=douban-web_anonymous';
            // =====
            $articles[1]['title'] = '艾比斯之梦';
            $articles[1]['description'] = '日本赛伯朋克最佳作，补完“机器人三定律”超越阿莫西夫！';
            $articles[1]['imageUrl'] = 'https://img3.doubanio.com/lpic/s26684895.jpg';
            $articles[1]['url'] = 'https://book.douban.com/subject/24538715/';
            // =====
            $articles[2]['title'] = '软件体的生命周期';
            $articles[2]['description'] =
                '《软件体的生命周期》结集特德•姜最新创作的六个短篇或中篇小说：《软件体的生命周期》、《赏心悦目》、《商人和炼金术士之门》、《呼吸——宇宙的毁灭》、《前路迢迢》及《达西的新型自动机器保姆》。《软件体的生命周期》从人工智能的诞生、成长与衰落着手，探讨了人工智能的发展牵扯到的技术、道德、情感、认知、法律与伦理方面的问题，堪称一部人工智能发展史。';
            $articles[2]['imageUrl'] = 'https://img3.doubanio.com/lpic/s28033065.jpg';
            $articles[2]['url'] = 'https://book.douban.com/subject/26295450/';

            return self::returnNewsXML($articles, $xmlData);
        } catch (Exception $e) {
            return self::returnTextXML($e->getMessage(), $xmlData);
        }
    }

    // 图文消息测试2
    public static function imgInfo2($param, $xmlData)
    {
        try {
            $articles[0]['title'] = '导论：人性皆有裂隙，那是我们共同的隐秘';
            $articles[0]['description'] =
                '人性皆有裂隙，而那也是光照进来的地方。倘若不是如此，心理学便不会在百余年中用好奇而温柔的目光凝视着矛盾、复杂的我们，揣摩我们为应对生活中的种种情境，发展出的自己的行为模式。' . "\n" .
                '这些惯常的、适应性的行为模式被定义为人格。它是我们人性的裂隙，独特的纹理揭示着我们的隐秘，隐秘中有冲突与矛盾，记忆和过往，有我们成长的生命力和最渴望回避的痛苦。一旦我们决定去了解它们，我们就有了认识彼此、消除隔阂的那一束光。';
            $articles[0]['imageUrl'] = 'https://img1.doubanio.com/dae/niffler/niffler/images/7be0effe-3f69-11e7-8261-0242ac11001b.png';
            $articles[0]['url'] = 'https://m.douban.com/time/column/43?dt_time_source=douban-web_anonymous';

            return self::returnNewsXML($articles, $xmlData);
        } catch (Exception $e) {
            return self::returnTextXML($e->getMessage(), $xmlData);
        }
    }
}
