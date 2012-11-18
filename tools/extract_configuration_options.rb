#encoding: utf-8

=begin
This script is used to extract what configuration options Textura looks for in different places.
The script can be run in two different modes:
1) To just display all used configuration options, run the script without any arguments.
2) To display all used configuration options and what file they appear in, run the script with
   the single argument --full.
Hopefully this will make it easier to document what options are available. :D
=end

# Locate Textura source directory
TEXTURA_SRC_TOP_DIR =
  File.join(
    File.dirname(
      File.dirname(
        File.expand_path(__FILE__)
      )
    ),
    'src/textura'
  )

# Create a regexp that finds calls to configuration options
regexp = /.getConfigurationOption\((.+?)\)/

# Check if filenames should be displayed
display_files = ARGV.count > 0 && ARGV[0] == '--full'

# Switch working directory to Textura source directory
Dir.chdir(TEXTURA_SRC_TOP_DIR)

# Get a list of all available PHP files and sort them alphabetically
files = Dir.glob('**/*.php').sort

# Create a hold to hold found configuration options
found_options = {}

# Iterate over all found PHP files
files.each do |file_path|
  # Open file
  File.open(File.join(Dir.getwd, file_path)) do |file|
    # Create list of possible configuration options
    elems = file.read.scan(regexp)
    # Reject all candidates involving dynamic content
    elems.reject! { |e| e.to_s.include?('$') }
    # Strip enclosing string chars
    elems.map! { |e| e.to_s[3...-3] }
    # Add new elements (if any)
    elems.each do |elem|
      found_options[elem] = [] unless found_options.has_key?(elem)
      found_options[elem] << file_path
    end
  end
end

# Print list of configuration options
if display_files
  keys = found_options.keys.sort
  longest_key = keys.max { |a, b| a.length <=> b.length }.length
  keys.each_with_index do |key, idx|
    puts "#{key.ljust(longest_key)}\t[#{found_options[key].join(', ')}]"
  end
else
  puts found_options.keys.sort.join($/)
end