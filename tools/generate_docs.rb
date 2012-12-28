dir = File.dirname(File.dirname(File.expand_path(__FILE__)))

doc_dir = File.join(dir, 'docs')

ignore_dirs = [
  File.join(dir, 'site', '*'),
  File.join(dir, 'src', 'htmlbuilder', '*'),
  File.join(dir, 'src', 'phamlp', '*'),
  File.join(dir, 'src', 'spyc', '*')
]

Dir.chdir(dir) do
  system "phpdoc -d \"#{dir}\" -t \"#{doc_dir}\" -i \"#{ignore_dirs.join(',')}\""
end

