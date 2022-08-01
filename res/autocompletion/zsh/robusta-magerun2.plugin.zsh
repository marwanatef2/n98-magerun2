#compdef robusta-magerun2.phar

# Installation:
#  This assumes that "robusta-magerun2.phar" is in your path
#
#  Place this file in a directory listed in the $fpath variable.
#  You can add a directory to $fpath by adding a line like this to your
#  ~/.zshrc file:
#
#      fpath=(~/.zsh_completion.d $fpath)
#
# Oh My Zsh Installation:
#  Copy to ~/.oh-my-zsh/custom/plugins/robusta-magerun2/robusta-magerun2.plugin.zsh
#  Edit plugins in your .zshrc e.g. "plugins=(git robusta-magerun2)"
#
#  It will load the next time a shell session is started

_robusta_magerun2_get_command_list () {
  robusta-magerun2.phar --raw --no-ansi list | sed "s/[[:space:]].*//g"
}

_robusta_magerun2 () {
  compadd `_robusta_magerun2_get_command_list`
}

compdef _robusta_magerun2 robusta-magerun2.phar
