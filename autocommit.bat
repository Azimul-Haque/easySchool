current="`date +'%Y-%m-%d %H:%M:%S'`"
msg="Updated: $current"
git commit -a -m "$msg"
git push