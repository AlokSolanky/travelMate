counter = 1;
function openBlog(n)
{
    var item = document.querySelectorAll(".blog-cursor");
    var card = document.querySelectorAll("#blog-card");
    console.log(item.length);
    for(let i = 0;i<item.length;i++)
    {
        item[i].style.display="none";
        item[n-1].style.display = "block";
        card[n-1].style.height="100%";
        card[n-1].style.overflow = "auto";
    }
}