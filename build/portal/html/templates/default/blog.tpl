{*

    ////////////////////////////////////////////////////////////////////////////////
    //                 ADS-B RECEIVER PORTAL TEMPLATE INFORMATION                 //
    // ========================================================================== //
    // Template Set: default                                                      //
    // Template Name: blog.tpl                                                    //
    // Version: 2.0.0                                                             //
    // Release Date:                                                              //
    // Author: Joe Prochazka                                                      //
    // Website: https://www.swiftbyte.com                                         //
    // ========================================================================== //
    // Copyright and Licensing Information:                                       //
    //                                                                            //
    // Copyright (c) 2015-2016 Joseph A. Prochazka                                //
    //                                                                            //
    // This template set is licensed under The MIT License (MIT)                  //
    // A copy of the license can be found package along with these files.         //
    ////////////////////////////////////////////////////////////////////////////////

*}
{area:head/}
{area:contents}
            <div class="container">
                <h1>Blog Posts</h1>
                <hr />
                {foreach page:blogPosts as post}
                <h2><a href="post.php?title={post->title}">{post->title}</a></h2>
                <p>Posted <strong>{post->date}</strong> by <strong>{post->author}</strong>.</p>
                <div>{post->contents}</div>
                {/foreach}
                <ul class="pagination">
                    {for pageNumber eq 1 to page:pageLinks}
                    <li><a href="blog.php?page={pageNumber}">{pageNumber}</a></li>
                    {/for}
                </ul>
            </div>
{/area}
{area:scripts/}
