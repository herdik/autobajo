let accept = document.querySelector(".accept")
let reject = document.querySelector(".reject")

let cookies = document.querySelector(".cookies")

let googleMap = document.querySelector("iframe")
sectionWithoutMap = document.querySelector(".dashboard-menu")

accept.addEventListener("click", () => {

   let temp_id = "id" + Math.random().toString(16).slice(2)

   let expiredDate = new Date();
   let no_of_months = 1;
   expiredDate.setMonth(expiredDate.getMonth() + no_of_months)
   
   document.cookie = 'pneu=true; expires = ' + expiredDate.toUTCString()

   cookies.style.display = "none"
   
})


reject.addEventListener("click", () => {

   

   sessionStorage.setItem('reject_cookie', 'true')

   cookies.style.display = "none"

})


// accepted cookies
document.cookie.split(';').map(function(cookiestring) {
   cs = cookiestring.trim().split('=');
   if(cs.length === 2) {
      let moje = {'name' : cs[0], 'value' : cs[1]};
      if (moje.name === "pneu"){
         if(moje.value === "true"){
            cookies.style.display = "none"
         }
      }
  } 
})

// rejected cookies
let rejectedCookies = sessionStorage.getItem('reject_cookie')


if (rejectedCookies){
   cookies.style.display = "none"
   if (googleMap != null){
      // rejected cookies remove google map
      googleMap.remove()
      sectionWithoutMap.style.justifyContent = "center"
   }
   
} 



