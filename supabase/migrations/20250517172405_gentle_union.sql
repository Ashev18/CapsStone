/*
  # Initial Schema Setup

  1. New Tables
    - `profiles`
      - Stores user profile information
      - Links to auth.users for authentication
    - `roles`
      - Defines user roles (admin, student)
    - `student_records`
      - Stores academic records
    - `course_tracks`
      - Stores available courses and tracks
    
  2. Security
    - Enable RLS on all tables
    - Add policies for data access
*/

-- Create roles enum
CREATE TYPE user_role AS ENUM ('admin', 'student');

-- Create profiles table
CREATE TABLE IF NOT EXISTS profiles (
  id uuid PRIMARY KEY REFERENCES auth.users(id),
  role user_role NOT NULL DEFAULT 'student',
  first_name text NOT NULL,
  middle_name text,
  surname text NOT NULL,
  address text,
  lrn text UNIQUE,
  email text UNIQUE NOT NULL,
  created_at timestamptz DEFAULT now(),
  updated_at timestamptz DEFAULT now()
);

-- Create course_tracks table
CREATE TABLE IF NOT EXISTS course_tracks (
  id uuid PRIMARY KEY DEFAULT gen_random_uuid(),
  name text NOT NULL,
  type text NOT NULL CHECK (type IN ('SHS', 'College')),
  created_at timestamptz DEFAULT now()
);

-- Create student_records table
CREATE TABLE IF NOT EXISTS student_records (
  id uuid PRIMARY KEY DEFAULT gen_random_uuid(),
  profile_id uuid REFERENCES profiles(id),
  course_track_id uuid REFERENCES course_tracks(id),
  year_level text NOT NULL,
  academic_year text NOT NULL,
  semester text,
  created_at timestamptz DEFAULT now(),
  updated_at timestamptz DEFAULT now()
);

-- Enable RLS
ALTER TABLE profiles ENABLE ROW LEVEL SECURITY;
ALTER TABLE course_tracks ENABLE ROW LEVEL SECURITY;
ALTER TABLE student_records ENABLE ROW LEVEL SECURITY;

-- Create policies
CREATE POLICY "Users can view own profile"
  ON profiles FOR SELECT
  TO authenticated
  USING (auth.uid() = id);

CREATE POLICY "Admins can view all profiles"
  ON profiles FOR SELECT
  TO authenticated
  USING (
    EXISTS (
      SELECT 1 FROM profiles
      WHERE id = auth.uid() AND role = 'admin'
    )
  );

CREATE POLICY "Public can view course tracks"
  ON course_tracks FOR SELECT
  TO authenticated
  USING (true);

CREATE POLICY "Students can view own records"
  ON student_records FOR SELECT
  TO authenticated
  USING (profile_id = auth.uid());

CREATE POLICY "Admins can view all records"
  ON student_records FOR SELECT
  TO authenticated
  USING (
    EXISTS (
      SELECT 1 FROM profiles
      WHERE id = auth.uid() AND role = 'admin'
    )
  );

-- Insert initial course tracks
INSERT INTO course_tracks (name, type) VALUES
  ('STEM', 'SHS'),
  ('GAS', 'SHS'),
  ('ABM', 'SHS'),
  ('TVL', 'SHS'),
  ('ICT', 'SHS'),
  ('BSIS', 'College'),
  ('DHRT', 'College'),
  ('ACT', 'College'),
  ('DIT', 'College');

-- Create function to handle profile updates
CREATE OR REPLACE FUNCTION handle_profile_update()
RETURNS TRIGGER AS $$
BEGIN
  NEW.updated_at = now();
  RETURN NEW;
END;
$$ LANGUAGE plpgsql;

-- Create trigger for profile updates
CREATE TRIGGER profile_updated
  BEFORE UPDATE ON profiles
  FOR EACH ROW
  EXECUTE FUNCTION handle_profile_update();