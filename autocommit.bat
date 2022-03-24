set INTERVAL=10
:loop

git commit -a -m "Commit %date% %time% %random%"
git push

timeout %INTERVAL%
goto:loop
