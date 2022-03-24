set INTERVAL=30
:loop

git commit -a -m "Commit %date% %time% %random%"
git push

timeout %INTERVAL%
goto:loop
