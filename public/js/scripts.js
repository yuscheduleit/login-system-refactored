//adapted from https://stackoverflow.com/questions/10730362/get-cookie-by-name
function getCookie(cookieName)
{
    const regex = new RegExp('(^| )' + cookieName + '=([^;]+)')
    const match = document.cookie.match(regex)
    if (match) {
        return match[2]
    }
}