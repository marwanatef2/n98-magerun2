# Installation:
#  This assumes that "robusta-magerun2.phar" is in your path!
#  Copy to ~/.config/fish/completions/robusta-magerun2.phar.fish
# open new or restart existing shell session

for cmd in (robusta-magerun2.phar --raw --no-ansi list | sed "s/[[:space:]].*//g");
    complete -f -c robusta-magerun2.phar -a $cmd;
end

