class Student(Person):
  def __init__(self, fname, lname, year):
    super().__init__(fname, lname)
    self.graduationyear = year

  def welcome(self):
    print("Welcome", self.firstname, self.lastname, "to the class of", self.graduationyear)

  def my_function(self,fname):
  	var_for_test = "Just a var for test"
  	print(fname + " Refsnes")

  def my_function(self,*kids):
  	print("The youngest child is " + kids[2])

  def my_function(self,child3, child2, child1):
  	print("The youngest child is " + child3)