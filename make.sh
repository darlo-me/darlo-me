#!/bin/sh
set -Eeuo pipefail

output_folder="$1"

_yesno() {
	prompt="$1"
	default="$2"
	shift 2

	while true; do
		printf "$prompt" "$@"
		read -r yn
		case "$yn" in
			n|N) return 1 ;;
			y|Y) return 0 ;;
			"")
				case "$default" in
					n|N) return 1 ;;
					y|Y) return 0 ;;
				esac
				;;
		esac
	done
}

error() {
	>&2 printf "== ERROR: RETURN %s ==\n" "$?"
	_yesno "remove %s? [y] " "y" "$output_folder" && rm -rfv -- "$output_folder"
}
trap error ERR

# $1 input directory (should not start with -)
# $2 output directory
recurse() {
	inp="$1" dst="$2"
	mkdir -v -- "$dst"
	for i in "$inp"/*; do
		if [ -d "$i" ]; then
			output="$dst/$(basename -- "$i")"
			recurse "$i" "$output"
		else
			output="$dst/$(basename -- "$i")"
			case "$i" in
				*.php)
					output="${output%\.php}"
					>&2 printf "= Interpreting file %s -> %s\n" "$i" "$output"
					php "$i" > "${output}" ;; # $i not -- here for php since directory is preceding
				*)
					>&2 printf "= Copying file %s -> %s\n" "$i" "$output"
					cp -v -- "$i" "$output" ;;
			esac
		fi
	done
}

inp="$(dirname "$0")/web/pub"
recurse "$inp" "$output_folder"

nophp="$inp/.nophp"
if [ -d "$nophp" ]; then
	>&2 printf "= Copying dir %s -> %s\n" "$nophp" "$output_folder"
	cp -Rv --no-preserve=mode -- "$nophp" "$output_folder"
fi
