SELECT * FROM clubteam as c
                      INNER JOIN team as t ON c.TeamID = t.TeamID
                      WHERE c.TeamID = '1246' 
                            OR t.Host = 'asmith'