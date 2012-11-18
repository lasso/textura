#encoding: utf-8

=begin
This script is used to extract what configuration options Textura looks for in different places.
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

# Switch working directory to Textura source directory
Dir.chdir(TEXTURA_SRC_TOP_DIR)

# Get a list of all available PHP files and sort them alphabetically
files = Dir.glob('**/*.php').sort

# Create an array to hold found configuration options
found_options = []

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
    found_options.concat(elems) unless elems.empty?
  end
end

# Sort found configuration options alphabetically
found_options.sort!

# Print list of configuration options
puts found_options.join("\n")